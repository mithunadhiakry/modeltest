<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

use frontend\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

    $session = Yii::$app->session;
    if($session->has('chapter_list')){
        $chapter_list_session = $session->get('chapter_list');
    }else{
        $chapter_list_session = array();
    }

if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){
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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="<?= Url::base('') ?>/images/favicon.png">
    <?php $this->head() ?>

    <?php  

        $this->registerCssFile("http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", [
              'media' => 'all',
        ], 'font-awesome');

        $this->registerCssFile(Url::base('')."/css/jquery.countdown.css", [
              'media' => 'all',
        ], 'timer');

        $this->registerCssFile(Url::base('')."/css/bootstrap.css", [
              'media' => 'all',
        ], 'bootstrap');

        $this->registerCssFile(Url::base('')."/css/datepicker.css", [
              'media' => 'all',
        ], 'bootstrap-datepicker');

         $this->registerCssFile(Url::base('')."/css/bxslider.css", [
              'media' => 'all',
        ], 'bxslider');

          $this->registerCssFile(Url::base('')."/css/contact-buttons.css", [
              'media' => 'all',
        ], 'contact-buttons');
        
        $this->registerCssFile(Url::base('')."/css/styles.css", [
              'media' => 'all',
        ], 'style');

    ?>
    <?= $this->registerJsFile(Url::base()."/js/jquery.bxslider.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/bootstrap-dialog.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/jquery.plugin.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/jquery.countdown.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/jquery.maskedinput.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
    <?= $this->registerJsFile(Url::base()."/js/jquery.contact-buttons.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>    
</head>
<body>
    <?php $this->beginBody() ?>
    
    <?php
        if(isset(Yii::$app->user->identity->id)){
            $user_data = User::find()->where(['id' => Yii::$app->user->identity->id ])->one();
        };
        
    ?>

    
<a id="baseurl" style="display:none;" href="<?= Yii::$app->urlManager->createAbsoluteUrl(''); ?>"></a>
    <!-- Start of header -->
    <div class="container-fluid">
        <div class="row">
            <div class="header_container inner_header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-xs-4">
                            <div class="row">
                               
                                <a href="http://model-test.com" class="logo">
                                    <img  alt="Logo" src="<?= Url::base('') ?>/images/logo.png">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10 col-sm-9 col-xs-8">
                            <div class="row">
                                <!-- <div class="header_top_container">
                                    <div class="cart_container">
                                        <i class="float-left fa fa-shopping-cart"></i>
                                        <div class="cart_content">
                                            <span class="cart_text">Basket</span>
                                            <span class="cart_number"><span><?= count($chapter_list_session); ?></span> Items(s)</span>
                                        </div>
                                        <a href="#" class="cart_checkout">checkout</a>
                                    </div>  
                                </div> -->

                                <div class="header_bottom_container">
                                    <div class="mobilemenu_container">
                                        <img  alt="Mobile Menu" src="<?= Url::base('') ?>/images/menu.png">
                                    </div>

                                    <div class="mobilemenu_container_cross">
                                        <img  alt="Cross" src="<?= Url::base('') ?>/images/cross.png">
                                    </div>
                                    <ul class="main_menu inner-menu">
                                        <li>
                                            <?php
                                                if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){
                                            ?>
                                                <a href="<?= Url::toRoute(['dashboard/index']); ?>">
                                                    <img  alt="Model Test" src="<?= Url::base('') ?>/images/home.png" >
                                                </a>
                                            <?php }else{ ?>
                                                <a href="<?= Url::base(''); ?>">
                                                    <img  alt="Model Test" src="<?= Url::base('') ?>/images/home.png" >
                                                </a>
                                            <?php } ?>
                                        </li>

                                        <?php
                                            if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){
                                              
                                        ?>
                                                
                                                <li>
                                                    <a href="<?= Url::toRoute(['exam/examcenter']); ?>">
                                                        Exam Centre
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= Url::toRoute(['user/myexam']); ?>">
                                                        My Model Test
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="<?= Url::toRoute(['page/points-rewards']) ?>">Points & Rewards</a>
                                                </li>
                                                
                                               
                                                <li class="text_transform_lowercase inner_menu_left_border">
                                                    <a href="<?= Url::toRoute(['dashboard/index']); ?>">
                                                        <span class="avater">
                                                            <?php
                                                                if(!empty($model->image)){
                                                            ?>
                                                                    <img  alt="Student" src="<?= Url::base('') ?>/user_img/<?= $model->image; ?>">
                                                            <?php   }else{ ?>
                                                                <img  alt="Student" src="<?= Url::base('') ?>/images/avatar-test-taker.jpg">
                                                            <?php } ?>
                                                            
                                                        </span>
                                                        <?= $model->name; ?> 
                                                    </a>
                                                </li>
                                                <li class="text_transform_lowercase">
                                                    <a href="#">
                                                        <img  alt="Setting" src="<?= Url::base('') ?>/images/settings.png" >

                                                    </a>

                                                    
                                                    <ul class="signout_setting">
                                                        
                                                        <li>
                                                            <a href="<?= Url::toRoute(['user/view?tab=points_payments']); ?>">Account</a>
                                                        </li>

                                                        <li>
                                                            <a  data-method="post"  href="<?= Url::toRoute(['site/logout']); ?>">Signout</a>
                                                        </li>

                                                    </ul>
                                                </li>

                                        <?php
                                                
                                            }else{

                                        ?>
                                                <li>
                                                    <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Exam Centre</a>
                                                </li>
                                                <li>
                                                    <a href="<?= Url::toRoute(['page/membership']); ?>">Membership</a>
                                                    <!-- <span class="arrow_button">&nbsp;</span>
                                                    <ul>
                                                        <li>
                                                            <a href="<?= Url::toRoute(['page/points-rewards']) ?>">Point & Rewards</a>
                                                        </li>
                                                    </ul> -->
                                                </li>
                                               
                                                <li>
                                                    <a href="<?= Url::toRoute(['page/points-rewards']) ?>">Points & Rewards</a>
                                                </li>

                                                <li>
                                                    <a href="<?= Url::toRoute(['page/about-us']); ?>">About</a>
                                                </li>
                                                
                                        <?php
                                            }
                                           
                                        ?>
                                        
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of header -->
    

     <?= $content ?>
      <div class="container-fluid">
            <div class="row">
               <div class="bottom_arrow">
                    <i class="fa fa-arrow-up"></i>
               </div>
            </div>
        </div>

     <!-- start of footer contaier -->

        <div class="container-fluid">
            <div class="row">
                <div class="inner_footer_container">
                    <div class="container">
                        <div class="footer_left">
                            <span class="all_rights_reserve">
                                All right reserved @ <a href="http://model-test.com">model-test.com.</a>
                            </span>
                            <span class="developer_company">
                                Powered by Abedon.
                            </span>
                        </div>

                        <div class="footer_right">
                            <ul>
                                <li>
                                    <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Exam Centre</a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['page/membership']); ?>">Membership</a>
                                    <!-- <span class="up_arrow_button">&nbsp;</span>
                                    <ul>
                                        <li>
                                            <a href="<?= Url::toRoute(['page/points-rewards']) ?>">Point & Rewards</a>
                                        </li>
                                    </ul> -->
                                </li>

                                <li>
                                    <a href="<?= Url::toRoute(['page/discounts']); ?>">Discounts</a>
                                </li>

                                <li>
                                    <a href="<?= Url::toRoute(['page/how-to-pay']); ?>">How to Pay</a>
                                </li>
                               
                                <li>
                                    <a href="<?= Url::toRoute(['page/faq']); ?>">FAQ</a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['page/about-us']); ?>">About</a>
                                </li>
                                <li>
                                    <a href="<?= Url::toRoute(['page/contact-us']); ?>">Contact us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    <!-- end of footer container -->

     <?php

             $this->registerJs("

                $('.bottom_arrow').click(function() {
                      $('html, body').animate({ scrollTop: 0 }, 'slow');
                      return false;
                    });


             ", yii\web\View::POS_READY, 'move_up');   
            $this->registerJs("




            //     $(document).ready(function () {
            //             resize_function();

            //             $( window ).resize(function() {
            //                 resize_function();
            //             });

            //             function resize_function(){

            //                 var inner_container_height = $('.inner_container').height();
            //                 var window_height = $(window).height();
                           

            //                 if(inner_container_height != null){

            //                     if(inner_container_height+110 < window_height){
                                
            //                         $('.inner_footer_container').css({
            //                             'position':'fixed',
            //                             'bottom':'0'
            //                         });

            //                     }else{

            //                         $('.inner_footer_container').css({
            //                             'position':'absolute',
            //                             'bottom':'100%'
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
            //                         'width':'100%'
            //                     });
            //                 }
            //             }
            //         });

            // ", yii\web\View::POS_READY, 'resize_function');


        ?>

<?php

    $this->registerJs("

      $.contactButtons({
      buttons : {
        'facebook':   { class: 'facebook', use: true, link: 'https://www.facebook.com/modeltest4practice' },
        'google':     { class: 'gplus',    use: true, link: 'https://plus.google.com/+Modeltest4Practice' },
        'twitter':   { class: 'twitter',      use: true, link: 'https://twitter.com/ModelTestDotCom', icon: 'twitter', title: 'Visit on Twitter' },
        'youtube':   { class: 'youtube',      use: true, link: 'https://www.youtube.com/c/modeltest4practice', icon: 'youtube', title: 'Visit on YouTube' },
        'email':      { class: 'email',    use: true, link: 'mailto:support@model-test.com' }
      }
    });

", yii\web\View::POS_READY, 'social_buttons');

?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
