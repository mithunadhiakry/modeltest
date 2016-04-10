<?php
    use yii\helpers\Url;
?>
<div class="blog-commentSection">
    <div class="blog-blogCommentUserImage">
        <?php
            if(!empty($blog_comments->author_name->image)){
        ?>
                <img src="<?= Url::base('') ?>/user_img/<?= $blog_comments->author_name->image; ?>">
        <?php
            }else{
        ?>
                <img src="<?= Url::base('') ?>/images/avater.png">

        <?php
            }

        ?>
    </div>
    <div class="blog-blogCommentDescription">
       <span class="blog-authorName">
            <?= $blog_comments->author_name->name;  ?>
       </span>
        <span class="blog-postingDate">
            <?= date_format(date_create($blog_comments->time), 'jS F\, Y h:i A'); ?>                                        
        </span>
        <div class="blog-usersComment">
            <?= $blog_comments->comments; ?>
        </div>
    </div>
</div>