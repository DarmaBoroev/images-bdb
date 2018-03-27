<?php
/* @var $user frontend\models\User */
/* @var $this yii\web\View */
/* @var $currentUser frontend\models\User */
/* @var $modelPicture frontend\modules\user\models\forms\PictureForm */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->title = Html::encode($user->username);
?>

<div class="page-posts no-padding">
    <div class="row">
        <div class="page page-post col-sm-12 col-xs-12 post-82">
            <div class="blog-posts blog-posts-large">
                <div class="row">
                    <!-- profile -->
                    <article class="profile col-sm-12 col-xs-12">                                            
                        <div class="profile-title">
                            <img src="<?php echo $user->getPicture(); ?>" id="profile-picture" class="author-image" />
                            <div class="author-name"><?php echo Html::encode($user->username); ?></div>
                            <?php if ($currentUser && $currentUser->equals($user)): ?>
                                <a href="<?= Url::to(['/user/profile/update']) ?>" class="btn btn-default"><?= Yii::t('user/view', 'Edit profile') ?></a>
                            <?php endif;?>
                            <!--<a href="#" class="btn btn-default">Upload profile image</a>-->
                            
                            <br/>
                            <br/>
                            
                        </div>
                        
                        <?php if ($currentUser && !$currentUser->equals($user)): ?>
                            <?php if($currentUser->isFollowing($user->getId())):?>
                                <a href="<?php echo Url::to(['/user/profile/unsubscribe', 'id' => $user->getId()]); ?>" class="btn btn-info">Unsubscribe</a>
                            <?php else:?>
                                <a href="<?php echo Url::to(['/user/profile/subscribe', 'id' => $user->getId()]); ?>" class="btn btn-info" >Subscribe</a>
                            <?php endif;?>
                            <hr>
                            <h5>
                                <?php
                                echo Yii::t('menu', 'Friends, who are also following ');
                                echo Html::encode($user->username);
                                ?>:
                            </h5>
                            <div class="row">
                                <?php foreach ($currentUser->getMutualSubscribtionsTo($user) as $item): ?>
                                    <div class="col-md-12">
                                        <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
                                            <?php echo Html::encode($item['username']); ?>
                                        </a>
                                    </div>                
                                <?php endforeach; ?>
                            </div>
                            <hr>
                        <?php endif; ?>
                        <?php if($user->about):?>
                            <div class="profile-description">
                                <p><?php echo HtmlPurifier::process($user->about); ?></p>
                            </div>
                        <?php endif;?>
                        <div class="profile-bottom">
                            <div class="profile-post-count">
                                <span><?php echo $user->getPostCount();?> posts</span>
                            </div>
                            <div class="profile-followers">
                                <a href="#" data-toggle="modal" data-target="#myModal2"><?php echo $user->countFollowers();?> followers</a>
                            </div>
                            <div class="profile-following">
                                <a href="#" data-toggle="modal" data-target="#myModal1"><?php echo $user->countSubscribtions(); ?> following</a>
                            </div>
                        </div>
                    </article>
                    <div class="flash-messages">
                        <div class="col-md-12">
                            <?php if (Yii::$app->session->hasFlash('success')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo Yii::$app->session->getFlash('success'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (Yii::$app->session->hasFlash('danger')): ?>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo Yii::$app->session->getFlash('danger'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="row profile-posts">
                            <?php foreach($user->getPosts() as $post):?>
                                <div class="col-md-4 profile-post">
                                    <a href="<?php echo Url::to(['/post/default/view','id' => $post->id]);?>">
                                        <img src="<?php echo Yii::$app->storage->getFile($post->filename);?>" class="author-image" />
                                    </a>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getSubscribers() as $subscriber): ?>
                        <div class="col-md-10">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($subscriber['nickname']) ? $subscriber['nickname'] : $subscriber['id']]); ?>">
                                <?php echo Html::encode($subscriber['username']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($user->getFollowers() as $follower): ?>
                        <div class="col-md-10">
                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($follower['nickname']) ? $follower['nickname'] : $follower['id']]); ?>">
                                <?php echo Html::encode($follower['username']); ?>
                            </a>
                        </div>>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJsFile('@web/js/likes.js', [
    'depends' => JqueryAsset::className(),
]);