<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>

<div class="container">
    <div class="pages_404_container">
        <img src="<?=Url::base('')?>/images/404.jpg">
    </div>
</div>
<!-- <div class="container">
    <div class="row">
        <div class="inner_container">
            
            <div class="item teaser-page-404 inview" style="background-position: 0px 14px;">
                <div class="container_16">
                    <aside class="grid_16">
                        <h1 class="page-title"><?= $name; ?></h1>
                        <h2><?= nl2br(Html::encode($message)) ?></h2>
                        
                    </aside>
                </div>
            </div>

            <div class="site-main container_16" id="main">
                <div class="inner">
                    <div class="grid_16" id="primary">
                        <article class="single-404">
                            
                            <a href="<?= Url::home(); ?>" class="button medium black square" target="_self">Go Home</a>

                        </article>
                        
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            
        </div>
    </div>
</div> -->
    
