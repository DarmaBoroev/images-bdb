<?php


namespace frontend\components;

use frontend\components\StorageInterface;
use Yii;
use yii\base\Component;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * Description of Storage
 *
 * @author dboro
 */
class Storage extends Component implements StorageInterface{
    
    private $filename;
    
    /**
     * Save given UploadedFile instance to disk
     * @param UploadedFile $file
     * @return string
     */
    public function saveUploadedFile(UploadedFile $file) {
        $path = $this->preparePath($file);
        
        if($path && $file->saveAs($path)){
             return $this->filename;
        }
    }
    
    public function getFile(string $filename){
        return Yii::$app->params['storageUri'].$filename;
    }
    
    /**
     * Prepare path to save uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function preparePath(UploadedFile $file){
        $this->filename = $this->getFilename($file);
        
        $path = $this->getStoragePath() . $this->filename;
        
        $path = FileHelper::normalizePath($path);
        if(FileHelper::createDirectory(dirname($path))){
            return $path;
        }
    }
    
    /**
     * 
     * @param UploadedFile $file
     * @return string
     */
    protected function getFilename(UploadedFile $file){
        $hash = sha1_file($file->tempName); // sf23d3kgscls3k4jdslc34ls
        
        $name = substr_replace($hash, '/', 2, 0);// ds/f23d3kgscls3k4jdslc34ls
        $name = substr_replace($name, '/', 5, 0);// ds/f2/3d3kgscls3k4jdslc34ls
        return $name . '.' . $file->extension; // ds/f2/3d3kgscls3k4jdslc34ls.jpg
    }
        
    /**
     * 
     * @return string
     */
    protected function getStoragePath(){
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }
    
    
}
