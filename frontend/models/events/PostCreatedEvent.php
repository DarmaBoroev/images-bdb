<?php

namespace frontend\models\events;

use yii\base\Event;
use frontend\models\User;
use frontend\models\Post;

/**
 * DTO class
 *
 * @author dboro
 */
class PostCreatedEvent extends Event{
    
    /**
     * The post author
     * @var User 
     */
    public $user;
    
    /**
     * Post
     * @var Post
     */
    public $post;
    
    public function getUser() : User {
        return $this->user;
    }
    
    public function getPost() : Post {
        return $this->post;
    }
}
