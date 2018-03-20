<?php
/* @var $this yii\web\View */
/* @var $users frontend\models\User */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('menu', 'Other users');
?>
<div class="page-posts no-padding">                    
    <div class="row">                        
        <div class="page page-post col-sm-12 col-xs-12">
            <div class="blog-posts blog-posts-large">

                <div class="row">
                    <?php if ($users): ?>
                        <?php foreach ($users as $user): ?>
                            <?php /* @var $user User */ ?>

                            <!-- feed item -->
                            <article class="post col-sm-12 col-xs-12">                                            
                                <div class="post-meta">
                                    <div class="post-title">
                                        <img src="<?php echo $user->getPicture(); ?>" class="author-image" />
                                        <div class="author-name">
                                            <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => $user->getNickname()]); ?>">
                                                <?php echo Html::encode($user->username); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="user-description">
                                    <?php echo Html::encode($user->about);?>
                                </div>
                                <div class="mutual-friends">
                                    <?php if ($currentUser && !$currentUser->equals($user) && $mutualSubscribtions = $currentUser->getMutualSubscribtionsTo($user)): ?>
                                        <br>
                                        <h5>
                                            <?php 
                                            echo Yii::t('menu', 'Friends, who are also following '); 
                                            echo Html::encode($user->username); 
                                            ?>:
                                        </h5>
                                        <div class="row">
                                            <?php foreach ($mutualSubscribtions as $item): ?>
                                                <div class="col-md-12">
                                                    <a href="<?php echo Url::to(['/user/profile/view', 'nickname' => ($item['nickname']) ? $item['nickname'] : $item['id']]); ?>">
                                                        <?php echo Html::encode($item['username']); ?>
                                                    </a>
                                                </div>                
                                            <?php endforeach; ?>
                                         </div>
                                    <?php endif;?>
                                </div>
                                <hr/>
                            </article>
                            <!-- feed item -->
                            
                        <?php endforeach; ?>

                    <?php else: ?>
                        <div class="col-md-12">
                            No users found!
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

</div>

