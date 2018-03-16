<?php

namespace frontend\components;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface {
    
    public function bootstrap($app) {
        $cookieLanguage = $app->request->cookies['language'];
        if(isset($cookieLanguage) && in_array($cookieLanguage, $app->params['supportedLanguages'])){
            $app->language = $app->request->cookies['language'];
        }
    }
}
