<?php

namespace frontend\components;

use Intervention\Image\ImageManager;
use yii\base\Component;

/**
 * Description of Image
 *
 * @author dboro
 */
class Image extends Component{
    private $manager;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->manager = new ImageManager(array('driver' => 'imagick'));
    }
    
    public function getHeight(string $path){
        return $this->manager->make($path)->height();
    }
    
    public function getWidth(string $path){
        return $this->manager->make($path)->width();
    }
    
    public function resizeHeight($path, $newHeight){
        return $this->manager->make($path)->resize(null, $newHeight);
    }
    
    public function resizeWidth($path, $newWidth){
        return $this->manager->make($path)->resize($newWidth, null);
    }
}
