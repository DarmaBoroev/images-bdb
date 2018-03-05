<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="panel panel-default">

        <div class="panel-heading">
            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($currentUser->nickname) ? $currentUser->nickname : $currentUser->id]); ?>">
                <img src="<?php echo $currentUser->getPicture(); ?>" width="50" height="50"/>
            </a>
            <?php echo Html::encode($currentUser->username); ?>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(['id' => 'new_comment']);?>
                <?php $form = ActiveForm::begin(['id' =>'comment-create', 'options' => ['data-pjax' => true]]); ?>

                    <?= $form->field($commentModel, 'text')->textarea() ?>
                    <?= $form->field($commentModel, 'post_id')->hiddenInput(['value' => $post->id])->label(false); ?>
                    <?= $form->field($commentModel, 'user_id')->hiddenInput(['value' => $currentUser->id])->label(false); ?>
                    <?= Html::submitButton('Create comment', ['name'=>'create-comment-button', 'class' => 'btn btn-primary']); ?>

                <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>

        </div>
</div>