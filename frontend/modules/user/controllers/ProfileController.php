<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\forms\PictureForm;
use yii\web\UploadedFile;
use yii\web\Response;
use frontend\modules\user\models\forms\UpdateForm;
use frontend\modules\user\models\forms\PasswordChangeForm;


/**
 * Description of ProfileController
 *
 * @author dboro
 */
class ProfileController extends Controller {

    public function actionView($nickname) {

        $currentUser = Yii::$app->user->identity;

        $modelPicture = new PictureForm();

        return $this->render('view', [
                    'user' => $this->findUser($nickname),
                    'currentUser' => $currentUser,
                    'modelPicture' => $modelPicture
        ]);
    }

    public function actionUploadPicture() {
        
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');

        if ($model->validate()) {
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);
            
            if($user->save(false, ['picture'])){
                return [
                    'success' => true,
                    'pictureUri' => Yii::$app->storage->getFile($user->picture),
                ];
            }
        }
        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionDeletePicture(){
        if(Yii::$app->user->isGuest){
            return;
        }
        
        $currentUser = Yii::$app->user->identity;
        if($currentUser->deletePicture()){
            Yii::$app->session->setFlash('success', Yii::t('user/update', 'Picture deleted'));
        }else{
            Yii::$app->session->setFlash('danger', 'Error occured');
        }
        
        return $this->redirect(['/user/profile/update']);
    }
    
    public function actionUpdate(){
        $user = Yii::$app->user->identity;
        
        $model = new UpdateForm($user);
        $modelPicture = new PictureForm();
        
        if($model->load(Yii::$app->request->post()) && $model->update()){
            Yii::$app->session->setFlash('success', Yii::t('user/update', 'Infromation about you changed'));
            return $this->redirect(['/user/profile/update', 'nickname' => $user->getId()]);
        }
        
        return $this->render('update',[
            'model' => $model,
            'modelPicture' => $modelPicture,
            'user' => $user,
        ]);
    }
    
    public function actionPasswordChange(){
        $user = Yii::$app->user->identity;
        $model = new PasswordChangeForm($user);
        
        if($model->load(Yii::$app->request->post()) && $model->changePassword()){
            Yii::$app->session->setFlash('success', Yii::t('user/update', 'Password success changed'));
            return $this->refresh();
        }
        
        return $this->render('passwordChange', [
            'model' => $model,
        ]);
    }
    
    protected function findModel($id){
        if(($model = User::findOne($id)) !== null){
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * 
     * @param string $nickname
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUser($nickname) {

        if ($user = User::find()->where(['nickname' => $nickname])->orWhere(['id' => $nickname])->one()) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    public function actionSubscribe($id) {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;

        $user = $this->findUserById($id);

        $currentUser->followUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    public function actionUnsubscribe($id) {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $currentUser = Yii::$app->user->identity;

        $user = $this->findUserById($id);

        $currentUser->unfollowUser($user);

        return $this->redirect(['/user/profile/view', 'nickname' => $user->getNickname()]);
    }

    private function findUserById($id) {
        if ($user = User::findOne($id)) {
            return $user;
        }
        throw new NotFoundHttpException();
    }

    
}
