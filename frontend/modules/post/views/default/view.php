<?php
/* @var $post frontend\models\Post */
/* @var $this yii\base\View */
/* @var $currentUser frontend\models\User */
/* @var $comments frontend\models\Comment */

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);

$this->registerJsFile('@web/js/comment.js', [
    'depends' => JqueryAsset::className()
]);

?>

<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">
            <div class="blog-posts blog-posts-large">

                <div class="row">

                    <!-- feed item -->
                    <article class="post col-sm-12 col-xs-12">                                            
                        <div class="post-meta">
                            <div class="post-title">
                                <img src="<?php echo $post->user->getPicture();?>" class="author-image" />
                                <div class="author-name">
                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $post->user->getNickname()]);?>">
                                        <?php echo Html::encode($post->user->username); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="post-type-image">
                            <a href="#">
                                <img src="<?php echo $post->getImage(); ?>" alt="">
                            </a>
                        </div>
                        <div class="post-description">
                            <p><?php echo Html::encode($post->description); ?></p>
                        </div>
                        <div class="post-bottom">
                            <div class="post-likes">
                                <i class="fa fa-lg fa-heart-o"></i>
                                <span class="likes-count"><?php echo $post->countLikes(); ?></span>
                                &nbsp;&nbsp;&nbsp;
                                <a href="#" class="btn btn-default button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->getId(); ?>">
                                    Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
                                </a>
                                <a href="#" class="btn btn-default button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->getId(); ?>">
                                    Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
                                </a>
                            </div>
                            &nbsp;&nbsp;
                            <div class="post-date">
                                <span><?php echo $post->getDate();?></span>    
                            </div>
                            <div class="post-report">
                                <a href="#">Report post</a>    
                            </div>
                        </div>
                    </article>
                    <!-- feed item -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::begin(['id' => 'comments']);?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                    <div class="page-header">
                        <h3><small class="pull-right"><?php echo $post->countComments(); ?> </small> Comments </h3>
                    </div> 
                    <div class="comments-list">

                        <?php foreach ($post->getComments() as $comment): ?>
                            <div class="media">
                                <p class="pull-right"><small><?php echo $comment->getDate(); ?></small></p>
                                <a class="" href="<?php echo Url::to(['/user/profile/view', 'nickname' => $comment->user->getNickname()]); ?>">
                                    <img src="<?php echo $comment->user->getPicture(); ?>" width="50" height="50" class="img-circle">
                                </a>
                                <div class="media-body">

                                    <h4 class="media-heading user_name"><?php echo Html::encode($comment->user->username); ?></h4>
                                    <?php echo Html::encode($comment->text); ?>

                                    <p><small><a href=""></a><a href=""></a></small></p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

            </div>
        </div>
    </div>
<?php Pjax::end();?>
<br/><br/>
<div class="col-sm-12 col-xs-12">
    <div class="comment-respond">
        <h4>Comment:</h4>
        <?php Pjax::begin(['id' => 'new_comment']); ?>
        <?php $form = ActiveForm::begin(['id' => 'comment-create', 'options' => ['data-pjax' => true]]); ?>
        <p class="comment-form-comment">
            <?=
            $form->field($commentModel, 'text')->textarea([
                'rows' => 6,
                'class' => "form-control",
                'placeholder' => 'Type your comment',
                "aria-required" => true])->label(false);
            ?>
            <?= $form->field($commentModel, 'post_id')->hiddenInput(['value' => $post->id])->label(false); ?>
            <?= $form->field($commentModel, 'user_id')->hiddenInput(['value' => $currentUser->id])->label(false); ?>
        </p>
        <p class="form-submit">
            <?= Html::submitButton('Send', ['name' => 'create-comment-button', 'class' => 'btn btn-secondary']); ?>
        </p>				
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
    <br/><br/>
</div>

