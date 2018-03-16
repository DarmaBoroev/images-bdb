<?php

namespace backend\models;
use Yii;

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
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
            'complaints' => 'Complaints',
        ];
    }
    
    
    public static function findComplaints(){
        return Post::find()->where('complaints > 0')->orderBy('complaints DESC');
    }
    
    public function getImage(){
        return Yii::$app->storage->getFile($this->filename);
    }
    
    /**
     * Delete complaints record of Post in redis and nullifies complaints field in record(in DB) 
     * @return boolean
     */
    public function approve(){
        /*@var $redis Connection */
        $redis = Yii::$app->redis;
        $key = "post:{$this->id}:complaints";
        $redis->del($key);
        
        $this->complaints = 0;
        return $this->save(false, ['complaints']);
    }
    
    /**
     * Delete related data of post in Redis
     */
    public function deleteRecordsInRedis(){
        /* @var $redis Connection */
        $redis = Yii::$app->redis;
        $commentsKey = "post:{$this->id}:comments";
        $likesKey = "post:{$this->id}:likes";
        $complaintsKey = "post:{$this->id}:complaints";
        
        $redis->del($commentsKey);
        $redis->del($likesKey);
        $redis->del($complaintsKey);
    }
}
