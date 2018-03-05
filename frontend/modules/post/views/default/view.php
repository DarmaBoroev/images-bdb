<?php
/* @var $post frontend\models\Post */
/* @var $this yii\base\View */
/* @var $currentUser frontend\models\User */
/* @var $comments frontend\models\Comment */

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);

$this->registerJsFile('@web/js/comment.js', [
    'depends' => JqueryAsset::className()
]);

?>


<div class="post-default-index">
    <div class="row">
        <div class="col-md-12">
            <?php if ($post->user->username): ?>
                <?php echo $post->user->username; ?>
            <?php endif; ?>
        </div>
        <div class="col-md-12">

            <img src="<?php echo $post->getImage(); ?>"/>
        </div>
        <div class="col-md-12">
            <?php echo Html::encode($post->description); ?>
        </div>

        <div class="col-md-12">

        </div>
    </div>
</div>

<hr>

<div class="col-md-12">
    Likes: <span class="likes-count"><?php echo $post->countLikes(); ?></span>
    <a href="#" class="btn btn-primary button-unlike <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "display-none" : ""; ?>" data-id="<?php echo $post->getId(); ?>">
        Unlike&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-down"></span>
    </a>
    <a href="#" class="btn btn-primary button-like <?php echo ($currentUser && $post->isLikedBy($currentUser)) ? "" : "display-none"; ?>" data-id="<?php echo $post->getId(); ?>">
        Like&nbsp;&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span>
    </a>
</div>

<br><br><br><br>


<?php Pjax::begin(['id' => 'comments']); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h3><small class="pull-right"><?php echo count($comments);?> </small> Comments </h3>
                </div> 
                <div class="comments-list">
                    <?php foreach ($comments as $comment): ?>
                        <div class="media">
                            <p class="pull-right"><small><?php echo $comment->getDate();?></small></p>
                            <a class="media-left" href="<?php echo Url::to(['/user/profile/view', 'nickname' => $comment->user->getNickname()]);?>">
                                <img src="<?php echo $comment->user->getPicture();?>" width="50" height="50">
                            </a>
                            <div class="media-body">

                                <h4 class="media-heading user_name"><?php echo Html::encode($comment->user->username);?></h4>
                                <?php echo Html::encode($comment->text); ?>

                                <p><small><a href="">Edit</a> - <a href="">Share</a></small></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
<?php Pjax::end();?>

<br><br>

<div class="col-md-12">
    <?=
    $this->render('commentCreate', [
        'commentModel' => $commentModel,
        'currentUser' => $currentUser,
        'post' => $post,
    ])
    ?>

</div>
  

