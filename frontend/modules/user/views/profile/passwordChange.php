<?php
/* @var $this yii\base\View */
/* @var $model frontend\modules\user\models\forms\PasswordChangeForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('user/update', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile-password-change">
 
    <h1><?= Html::encode($this->title) ?></h1>
 
    <div class="user-form">
        <?php if(Yii::$app->session->hasFlash('success')):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif;?>
        <?php $form = ActiveForm::begin(); ?>
 
        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>
 
        <div class="form-group">
            <?= Html::submitButton(Yii::t('user/update', 'Save'), ['class' => 'btn btn-primary']) ?>
            <a href="<?= Url::to(['/user/profile/update']) ?>" class="btn btn-danger"><?= Yii::t('user/update', 'Cancel') ?></a>
        </div>
        <br/>
        <?php ActiveForm::end(); ?>
 
    </div>
 
</div>

