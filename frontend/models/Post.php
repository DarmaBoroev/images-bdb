<?php

namespace frontend\models;

use Yii;
use frontend\models\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $description
 * @property int $created_at
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
     * 
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
     * 
     * @param User $user
     * @return boolean
     */
    public function isLikedBy(User $user) {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        return $redis->sismember("likes:{$this->getId()}:likes", $user->getId());
    }

}
