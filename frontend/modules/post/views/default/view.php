<?php
/* @var $post frontend\models\Post */
/* @var $this yii\base\View */
use yii\helpers\Html;
?>

<div class="post-default-index">
    <div class="row">
        <div class="col-md-12">
            <?php if($post->user->username):?>
                <?php echo $post->user->username;?>
            <?php endif;?>
        </div>
        <div class="col-md-12">
            
            <img src="<?php echo $post->getImage();?>"/>
        </div>
        <div class="col-md-12">
            <?php echo Html::encode($post->description);?>
        </div>
    </div>
</div>
