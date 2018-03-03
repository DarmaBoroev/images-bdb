<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\post\models\forms\PostForm;
use yii\web\UploadedFile;
use frontend\models\Post;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller {

    /**
     * Renders the create view for the module
     * @return string
     */
    public function actionCreate() {
        $model = new PostForm(Yii::$app->user->identity);

        if ($model->load(Yii::$app->request->post())) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created');
                return $this->goHome();
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Renders the view view for the module
     * @param integer $id
     * @return string
     */
    public function actionView($id) {
        
        return $this->render('view',[
            'post' => $this->findPost($id),
        ]);
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

}
