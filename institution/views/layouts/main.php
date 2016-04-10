<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use institution\models\User;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'institution'){
    $user_id = Yii::$app->user->identity->id;
    $model = User::find()
                ->where(['id' => $user_id])
                ->one();
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
      <meta charset="<?= Yii::$app->charset ?>"/>
      <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <?= Html::csrfMetaTags(); ?>
      
      <title><?= Html::encode($this->title) ?></title>
      <link rel="icon" type="image/png" href="<?= Url::base('') ?>/images/favicon.png">
      <?php $this->head() ?>
      <?php
        $this->registerCssFile("http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", [
              'media' => 'all',
        ], 'font-awesome');
      ?>
      <?= $this->registerCssFile(Url::base()."/assets_institution/css_institution/bootstrap.css", ['media' => 'all',], 'bootstrap'); ?> 
      <?= $this->registerCssFile(Url::base()."/assets_institution/css_institution/datepicker.css", ['media' => 'all',], 'datepicker'); ?> 
      <?= $this->registerCssFile(Url::base()."/assets_institution/css_institution/styles.css", ['media' => 'all',], 'styles'); ?> 
     
      <?= $this->registerJsFile(Url::base()."/assets_institution/js/bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
      <?= $this->registerJsFile(Url::base()."/assets_institution/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
      <?= $this->registerJsFile(Url::base()."/assets_institution/js/bootstrap-dialog.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
</head>
    
<body>

    <?php $this->beginBody() ?>

        <div class="container-fluid">
            <div class="row">
                <div class="header_container">
                    <div class="container">
                        <div class="row">
                            
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="row">
                                    <a href="<?= Yii::$app->urlManagerAbsolute->baseUrl ?>" class="logo">
                                      <img src="<?= Url::base('') ?>/images/logo.png">
                                    </a>
                                </div>
                            </div>
  
                            <div class="col-md-10 col-sm-9 col-xs-8">
                                <div class="row">
                                    <div class="header_bottom_container">
                                        <ul class="main_menu inner-menu">
                                            <li>
                                                <a href="<?= Url::toRoute(['site/index']); ?>">
                                                     <img src="<?= Url::base('') ?>/images/home.png" >
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="<?= Url::toRoute(['courses/index']); ?>">
                                                    Courses
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= Url::toRoute(['batch/index']); ?>">
                                                    Batches
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= Url::toRoute(['students/index']); ?>">
                                                    Students
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?= Url::toRoute(['questionset/index']); ?>">
                                                    Test
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?= Url::toRoute(['students/newstudent']); ?>">
                                                    New Requested user
                                                </a>
                                            </li>
                                            
                                            <li class="inner_menu_left_border">
                                                <a href="<?= Url::toRoute(['site/index']); ?>">
                                                    <span class="avater">
                                                        <span class="avater">
                                                            <?php
                                                                if(!empty($model->image)){
                                                            ?>
                                                                    <img src="<?= Url::base('') ?>/user_img/<?= $model->image; ?>">
                                                            <?php   }else{ ?>
                                                                <img src="<?= Url::base('') ?>/images/avater.png">
                                                            <?php } ?>
                                                            
                                                        </span>
                                                    </span>
                                                    Saifur                                                  
                                                </a>
                                            </li>


                                            <li class="text_transform_lowercase">
                                                <a href="#">
                                                    <img src="<?= Url::base('') ?>/images/settings.png" >

                                                </a>

                                                
                                                <ul class="signout_setting">
                                                    
                                                    <li>
                                                        <a href="<?= Url::toRoute(['site/account']); ?>">Account</a>
                                                    </li>

                                                    <li>
                                                        <a  data-method="post"  href="<?= Url::toRoute(['site/logout']); ?>">Signout</a>
                                                    </li>

                                                </ul>
                                            </li>
                                          
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

            <?= $content ?> 


        <div class="container-fluid">
            <div class="row">
                <div class="inner_footer_container">
                    <div class="container">
                        <div class="footer_left">
                            <span class="all_rights_reserve">
                                All right reserved @ <a href="http://model-test.com/">model-test.com.</a>
                            </span>
                            <a class="developer_company" href="#">
                                 Powered by Abedon Enterprise. 
                            </a>
                        </div>

                        <div class="footer_right">
                            <ul>
                                
                                <li>
                                    <a href="<?= Yii::$app->urlManagerAbsolute->baseUrl ?>/page/faq">FAQ</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManagerAbsolute->baseUrl ?>/page/about-us">About us</a>
                                </li>
                                <li>
                                    <a href="<?= Yii::$app->urlManagerAbsolute->baseUrl ?>/page/contact-us">Contact us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <?php

            // $this->registerJs("




            //     $(document).ready(function () {
            //             resize_function();

            //             $( window ).resize(function() {
            //                 resize_function();
            //             });

            //             function resize_function(){

            //                 var inner_container_height = $('.inner_container').height();
            //                 var window_height = $(window).height();
                               
            //                    console.log(inner_container_height);
            //                 if(inner_container_height != null){

            //                     if(inner_container_height < window_height){
                                
            //                         $('.inner_footer_container').css({
            //                             'position':'fixed',
            //                             'bottom':'0'
            //                         });

            //                     }else{

            //                         $('.inner_footer_container').css({
            //                             'position':'absolute',
            //                             'bottom':'auto'
            //                         });

            //                     }

            //                 }

                           

            //                 var window_width = $( window ).width();
            //                 if(window_width < 641){
            //                     $('ul.main_menu').css({
            //                         'width':window_width
            //                     });
            //                 }else{
            //                     $('ul.main_menu').css({
            //                         'width':'auto'
            //                     });
            //                 }
            //             }
            //         });

            // ", yii\web\View::POS_READY, 'resize_function');


        ?>

    <?php $this->endBody() ?>
</body>


</html>

<?php $this->endPage() ?>

  
