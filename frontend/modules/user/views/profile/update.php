<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */


$this->title = Yii::t('user/view', 'Edit profile');
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        
        <label><?= Yii::t('user/view', 'Photo') ?></label>
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
        
        
        <?php $form = ActiveForm::begin(); ?>
            <br>
            <?php echo $form->field($model, 'username')->label(Yii::t('user/view', 'Username'));?>

            <?php echo $form->field($model, 'about')->label(Yii::t('user/view', 'About')); ?>

            <?php echo $form->field($model, 'nickname');?>
            
            <a href="<?= Url::to(['/user/profile/password-change']) ?>" class="btn btn-primary"><?= Yii::t('user/view', 'Change password') ?></a>
            
            <div class="form-group">
                <br>
                <?= Html::submitButton(Yii::t('user/view', 'Save'), ['class' => 'btn btn-info']) ?>
            </div>
            <br/><br/>

        <?php ActiveForm::end(); ?>

    </div>

</div>