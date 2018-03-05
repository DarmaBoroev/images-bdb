<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php Pjax::begin(); ?>
    <h3><?= $stringHash ?></h3>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
        <?= $form->field($commentModel, 'text')->textarea() ?>
    <?= Html::submitButton('Create commemt', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end();?>
    
    <?= Html::beginForm(['site/form-submission'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
    <?= Html::input('text', 'string', Yii::$app->request->post('string'), ['class' => 'form-control']) ?>
    <?= Html::submitButton('Hash String', ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?php Pjax::end(); ?>

