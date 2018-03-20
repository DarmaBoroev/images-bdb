<?php 
/* @var $model frontend\modules\post\models\forms\PostForm */
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="post-default-index">
    <h1><?php echo Yii::t('post/create', 'Create post');?></h1>
    <?php $form= ActiveForm::begin();?>
    
        <?php echo $form->field($model, 'picture')->fileInput()->label(Yii::t('post/create', 'Picture'));?>
    
        <?php echo $form->field($model, 'description')->label(Yii::t('post/create', 'Description'));?>
    
        <?php echo Html::submitButton(Yii::t('post/create', 'Create'));?>
        <br/><br/><br/><br/>
    <?php ActiveForm::end();?>
</div>