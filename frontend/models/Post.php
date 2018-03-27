<?php

namespace frontend\models;

use Yii;
use frontend\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use frontend\models\Comment;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
 * @property int $complaints
 */
class Post extends ActiveRecord {

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression(time()),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get image name
     * @return string
     */
    public function getImage() {
        return Yii::$app->storage->getFile($this->filename);
    }

    /**
     * get author of the post
     * @return User|null
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param User $user
     */
    public function like(User $user) {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->sadd("post:{$this->getId()}:likes", $user->getId());
        $redis->sadd("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * 
     * @param User $user
     */
    public function unlike(User $user) {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->srem("post:{$this->getId()}:likes", $user->getId());
        $redis->srem("user:{$user->getId()}:likes", $this->getId());
    }

    /**
     * 
     * @return integer
     */
    public function countLikes() {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->scard("post:{$this->getId()}:likes");
    }

    /**
     * Check whether given user liked current post
     * @param User $user
     * @return boolean
     */
    public function isLikedBy(User $user) {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("post:{$this->getId()}:likes", $user->getId());
    }

    /**
     * Get comments
     * @return array
     */
    public function getComments() {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * 
     * @return int
     */
    public function countComments() {
        $redis = Yii::$app->redis;
        return $redis->get("post:{$this->id}:comments");
    }
    
    protected function setCommentCounter(){
        $redis = Yii::$app->redis;
        $redis->set("post:{$this->id}:comments", 0);
    }
    
    public function afterSave($insert, $changedAttributes) {
        $this->setCommentCounter();
        parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * 
     * @return string
     */
    public function getDate(){
        return Yii::$app->formatter->asDate($this->created_at);
    }
    
    /**
     * Add complaint to post from given user
     * @param User $user
     * @return boolean
     */
    public function complain(User $user){
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->getId()}:complaints";
        
        if(!$redis->sismember($key, $user->getId())){
            $redis->sadd($key, $user->getId());
            $this->complaints++;
            return $this->save(false, ['complaints']);
        }
    }
    
    public function isReported(User $user){
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return (bool) $redis->sismember("post:{$this->getId()}:complaints", $user->getId());
    }
}
