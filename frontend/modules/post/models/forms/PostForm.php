<?php

namespace frontend\modules\post\models\forms;

use Yii;
use yii\base\Model;
use frontend\models\Post;
use frontend\models\User;

/**
 * Description of postForm
 *
 * @author dboro
 */
class PostForm extends Model{
    const MAX_DESCRIPTION_LENGTH = 1000;
    
    public $picture;
    public $description;
    
    private $user;
    
    public function rules() {
        return [
            [['picture'], 'file',
                'skipOnEmpty' => false,
                'extensions' => ['jpg', 'png'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize()],
            [['description'], 'string', 'max' => self::MAX_DESCRIPTION_LENGTH],
        ];
    }
    
    public function __construct(User $user) {
        $this->user = $user;
    }
    
    public function save(){
        if($this->validate()){
            $post = new Post();
            $post->description = $this->description;
            $post->created_at = time();
            $post->filename = Yii::$app->storage->saveUploadedFile($this->picture);
            $post->user_id = $this->user->getId();
            return $post->save(false);
        }
    }
    
    /**
     * 
     * @return integer
     */
    public function getMaxFileSize(){
        return Yii::$app->params['maxFileSize'];
    }
}
