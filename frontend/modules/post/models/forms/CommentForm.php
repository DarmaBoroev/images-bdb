<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Comment;
use frontend\models\User;

class CommentForm extends Model{
    public $text;
    public $user_id;
    public $post_id;
    
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


    public function save(){
        if($this->validate()){
            $comment = new Comment();
            $comment->user_id = intval($this->user_id);
            $comment->text = $this->text;
            $comment->post_id = intval($this->post_id);
            $comment->save();
        }
    }
}

