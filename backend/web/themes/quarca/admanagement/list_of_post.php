<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AdManagement;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

?>
<div class="post-view">

<ul class="post_sort">

    <?php
        $posts = AdManagement::find()->where(['ad_identifier'=>$page_id])->all();

        if(!empty($posts)){
          foreach ($posts as $value) {
            echo '<li data-id="'.$value->id.'" class="Post_'.$value->id.'">'; 
                echo '<div class="col-md-8">'.$value->ad_name.'</div>';
                echo '<div class="col-md-4">';
                    echo '<input type="button" class="btn btn-sm btn-primary view_post_btn" value="View" data_id="'.$value->id.'">';
                    echo '<input type="button" class="btn btn-sm btn-default update_post_btn" value="Update" data_id="'.$value->id.'" style="margin-left:10px;">';
                    echo '<input type="button" class="btn btn-sm btn-danger delete_post_btn" value="Delete" data_id="'.$value->id.'" style="margin-left:10px;">';                    
                echo '</div>';
            echo '</li>';
          }
          
        }
    ?>

</div>
