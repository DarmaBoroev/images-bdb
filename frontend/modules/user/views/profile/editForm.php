<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    
        <?php echo $form->field($model, 'username');?>

        <?php echo $form->field($model, 'email'); ?>

        <?php echo $form->field($model, 'about'); ?>
    
        <?php echo $form->field($model, 'nickname');?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        </div>
        <br/><br/>
    
    <?php ActiveForm::end(); ?>

</div>

