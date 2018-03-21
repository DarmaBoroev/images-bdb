<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */


$this->title = Yii::t('user/update', 'Editing profile');
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        
        <label><?= Yii::t('user/update', 'Photo') ?></label>
        <img src="<?php echo $user->getPicture(); ?>" width='200px' id="profile-picture" class="author-image" />
        <br>
        <?=
        FileUpload::widget([
            'model' => $modelPicture,
            'attribute' => 'picture',
            'url' => ['/user/profile/upload-picture'], // your url, this is just for demo purposes,
            'options' => ['accept' => 'image/*'],
            'clientEvents' => [
                'fileuploaddone' => 'function(e, data) {
                                            if(data.result.success){
                                                 $("#profile-image-success").show();
                                                 $("#profile-image-fail").hide();
                                                 $("#profile-picture").attr("src", data.result.pictureUri);
                                            }else{
                                                 $("#profile-image-fail").html(data.result.errors.picture).show();
                                                 $("#pfofile-image-success").hide();
                                            }
                                         }',
            ],
        ]);
        ?>
        <div class="alert alert-success display-none" id="profile-image-success">Profile image updated</div>
        <div class="alert alert-danger display-none" id="profile-image-fail"></div>
        
        <a href="<?= Url::to(['/user/profile/delete-picture']) ?>" class="btn btn-danger"><?= Yii::t('user/update', 'Delete picture') ?></a>
        
        <hr>
        <?php if(Yii::$app->session->hasFlash('success')):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif;?>
        <?php $form = ActiveForm::begin(); ?>
            
            <?php echo $form->field($model, 'username')->label(Yii::t('user/update', 'Username'));?>

            <?php echo $form->field($model, 'about')->label(Yii::t('user/update', 'About')); ?>

            <?php echo $form->field($model, 'nickname');?>          
            
            <div class="form-group">
                <?= Html::submitButton(Yii::t('user/update', 'Save'), ['class' => 'btn btn-info']) ?>
                
                <hr>
            </div>
        
        <?php ActiveForm::end(); ?>

        <label><?= Yii::t('user/update', 'Password') ?></label>
        <br>
        <a href="<?= Url::to(['/user/profile/password-change']) ?>" class="btn btn-primary"><?= Yii::t('user/update', 'Change password') ?></a>
        <br><br><br><br>
    </div>

</div>