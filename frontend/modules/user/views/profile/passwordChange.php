<?php
/* @var $this yii\base\View */
/* @var $model frontend\modules\user\models\forms\PasswordChangeForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('user/view', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-profile-password-change">
 
    <h1><?= Html::encode($this->title) ?></h1>
 
    <div class="user-form">
 
        <?php $form = ActiveForm::begin(); ?>
 
        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>
 
        <div class="form-group">
            <?= Html::submitButton(Yii::t('user/view', 'Save'), ['class' => 'btn btn-primary']) ?>
            <a href="<?= Yii::$app->request->referrer ?>" class="btn btn-danger"><?= Yii::t('user/view', 'Cancel') ?></a>
        </div>
        <br/>
        <?php ActiveForm::end(); ?>
 
    </div>
 
</div>

