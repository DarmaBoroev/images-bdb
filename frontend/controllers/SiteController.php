<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        
        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $currentUser->getFeed($limit);
        
        return $this->render('index', [
            'feedItems' => $feedItems,
            'currentUser' => $currentUser
        ]);
    }
    
    public function actionAbout(){
        return $this->render('about');
    }

    /**
     * Change app language and save in cookie
     */
    public function actionLanguage(){
        $language = Yii::$app->request->post('language');
        
        if(in_array($language, Yii::$app->params['supportedLanguages'])){
            Yii::$app->language = $language;
            
            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, //30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
            
            return $this->redirect(Yii::$app->request->referrer);
        }
        Yii::$app->session->setFlash('danger', 'Incorrect language');
        return $this->redirect(Yii::$app->request->referrer);
    }
}
