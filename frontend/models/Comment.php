<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use frontend\models\User;
use frontend\models\Post;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */
class Comment extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'post_id', 'user_id'], 'required'],
            [['text'], 'string'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDate() {
        return Yii::$app->formatter->asDate($this->created_at);
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    
    public function getPost(){
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
    
    public function afterSave($insert, $changedAttributes) {
        $this->incrCounter();
        $this->text = "";
        parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete() {
        $this->decrCounter();
        parent::afterDelete();
    }
    
    public function incrCounter() {
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $redis->incr("post:{$this->post_id}:comments");
    }
    
    public function decrCounter(){
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        if($redis->get("post:{$this->post_id}:comments")){
            $redis->decr("post:{$this->post_id}:comments");
        }
    }
    
}
