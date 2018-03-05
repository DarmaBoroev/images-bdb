<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use frontend\models\User;
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
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }
    
      /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getDate(){
        return Yii::$app->formatter->asDate($this->created_at);
    }
    
    public function countComment(){
        return $this->find()->count();
    }
    
    /**
     * 
     * @return User
     */
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
