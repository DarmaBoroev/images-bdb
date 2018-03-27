<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\post\models\forms\PostForm;
use yii\web\UploadedFile;
use frontend\models\Post;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\models\Comment;
use frontend\models\User;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller {

    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionCreate() {
        $currentUser = Yii::$app->user->identity;
        $model = new PostForm($currentUser);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created');
                return $this->redirect(['/user/profile/view', 'nickname' => $currentUser->getNickname()]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id){
        $post = $this->findPost($id);
        
        /* @var $currentUser User */
        $currentUser = Yii::$app->user->identity;
        
        if($post->delete()){
            Yii::$app->session->setFlash('success', 'Post deleted');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to post delete');
        }
        return $this->redirect(['/user/profile/view', 'nickname' => $currentUser->getNickname()]);
    }

    /**
     * Renders the view view for the module
     * @param integer $id
     * @return string
     */
    public function actionView($id) {

        $currentUser = Yii::$app->user->identity;
        $commentModel = new Comment();
        
        if($commentModel->load(Yii::$app->request->post())) {
            $commentModel->save();
        }
        
        return $this->render('view', [
            'post' => $this->findPost($id),
            'commentModel' => $commentModel,
            'currentUser' => $currentUser,
        ]);
    }
    
    public function actionDeleteComment($id){
        $comment = $this->findComment($id);
        
        if($comment->delete()){
            Yii::$app->session->setFlash('success', Yii::t('post/view', 'Your comment deleted'));
            return $this->redirect(['/post/default/view', 'id' => $comment->post_id]);
        }
        
        Yii::$app->session->setFlash('danger', Yii::t('post/view', 'Failed to delete comment'));
        return $this->redirect(['/post/default/view', 'id' => $comment->post_id]);
    }
    
    /**
     * 
     * @return array
     */
    public function actionLike() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $currentUser = Yii::$app->user->identity;

        $id = Yii::$app->request->post('id');

        $post = $this->findPost($id);

        $post->like($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }

    /**
     * 
     * @return array
     */
    public function actionUnlike() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $currentUser = Yii::$app->user->identity;

        $id = Yii::$app->request->post('id');

        $post = $this->findPost($id);

        $post->unlike($currentUser);

        return [
            'success' => true,
            'likesCount' => $post->countLikes(),
        ];
    }
    
    /**
     * Add complain to post
     * @return array
     */
    public function actionComplain(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/user/default/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        $id = Yii::$app->request->post('id');
        
        /* @var $currentUser frontent\models\User */
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        
        if($post->complain($currentUser)){
            return [
                'success' => true,
                'text' => 'Post reported'
            ];
        }
        
        return [
            'success' => false,
            'text' => 'Error'
        ];
        
    }

    /**
     * 
     * @param integer $id
     * @return Post
     * @throws NotFoundHttpException
     */
    private function findPost($id) {
        if ($post = Post::findOne($id)) {
            return $post;
        }
        throw new NotFoundHttpException();
    }
    
    private function findComment($id){
        if($comment = Comment::findOne($id)){
            return $comment;
        }
        throw new NotFoundHttpException();
    }

}
