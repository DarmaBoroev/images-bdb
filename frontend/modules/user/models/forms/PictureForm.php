<?php

namespace frontend\modules\user\models\forms;
use yii\base\Model;
use Yii;
use Intervention\Image\ImageManager;
/**
 * Description of PictureForm
 *
 * @author dboro
 */
class PictureForm extends Model{
    public $picture;
    
    public function rules() {
        return [
            [['picture'], 'file',
                'extensions' => ['jpg'],
                'checkExtensionByMimeType' => true,
                'maxSize' => $this->getMaxFileSize(),
            ],
        ];
    }
    
    public function __construct() {
         $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'resizePicture']);
    }
    
    /**
     * Resize image if needed
     */
    public function resizePicture(){
        if($this->picture->error){
            return;
        }
        
        $width = Yii::$app->params['profilePicture']['maxWidth'];
        $height = Yii::$app->params['profilePicture']['maxHeight'];
        
        $manager = new ImageManager(array('driver' => 'imagick'));
        
        $image = $manager->make($this->picture->tempName);
        
        $image->resize($width, $height, function($constraint){
            //Пропорции изображения оставлять такими же
            $constraint->aspectRatio();
            
            //Изображения, размером меньше заданных $width $height не будут изменены
            $constraint->upsize();
            
        })->save();
    }
    
    public function getMaxFileSize(){
        return Yii::$app->params['maxSizeFile'];
    }
}
