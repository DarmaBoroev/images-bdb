<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
/**
 * Description of ProfileController
 *
 * @author dboro
 */
class ProfileController extends Controller{
    public function actionView($id){
        return $this->render('view', [
            'id' => $id, 
            'user' => $this->findUser($id),
        ]);
    }
    
    private function findUser($id){
        if($user = User::find()->where(['id' => $id])->one()){
            return $user;
        }
        throw new NotFoundHttpException;
    }
}
