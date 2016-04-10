<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <?php  

        $this->registerCssFile("http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", [
              'media' => 'all',
        ], 'font-awesome');

        $this->registerCssFile(Url::base('')."/css/bootstrap.min.css", [
              'media' => 'all',
        ], 'bootstrap');
        
        $this->registerCssFile(Url::base('')."/css/styles.css", [
              'media' => 'all',
        ], 'style');
    ?>

    <?php
        $this->registerJsFile(Url::base('')."/js/jquery-1.10.2.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        
    ?>


</head>
<body>
    <?php $this->beginBody() ?>
        <!-- Start of header -->
        <div class="container-fluid">
            <div class="row">
                <div class="header_container">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 col-sm-3 col-xs-4">
                                <div class="row">
                                    <a href="#" class="logo">
                                        <img src="<?= Url::base('') ?>/images/logo.png">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-9 col-xs-8">
                                <div class="row">
                                    <div class="header_top_container">
                                        <div class="cart_container">
                                            <i class="float-left fa fa-shopping-cart"></i>
                                            <div class="cart_content">
                                                <span class="cart_text">Basket</span>
                                                <span class="cart_number">0 Items(s)</span>
                                            </div>
                                            <a href="#" class="cart_checkout">checkout</a>
                                        </div>  
                                    </div>

                                    <div class="header_bottom_container">
                                        <div class="mobilemenu_container">
                                            <img src="<?= Url::base('') ?>/images/menu.png">
                                        </div>

                                        <div class="mobilemenu_container_cross">
                                            <img src="<?= Url::base('') ?>/images/cross.png">
                                        </div>
                                        <ul class="main_menu">
                                            <li>
                                                <a href="#"><i class="fa fa-home"></i></a>
                                            </li>
                                            <li>
                                                <a href="#">Exam Center</a>
                                            </li>
                                            <li>
                                                <a href="#">Membership</a>
                                            </li>
                                            <li>
                                                <a href="#">How to Pay</a>
                                            </li>
                                            <li>
                                                <a href="#">Discounts</a>
                                            </li>
                                            <li>
                                                <a href="#">FAQ</a>
                                            </li>
                                            <li>
                                                <a href="#">About us</a>
                                            </li>
                                            <li>
                                                <a href="#">Contact us</a>
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
        <!-- End of header -->

        <?= $content ?>
        
        <div class="container">
            <div class="row">
                <div class="payment_container">
                    <img src="<?= Url::base('') ?>/images/payment_icon.png">
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                resize_function();

                $( window ).resize(function() {
                    resize_function();
                });

                function resize_function(){
                    var window_width = $( window ).width();
                    if(window_width < 641){
                        $('ul.main_menu').css({
                            'width':window_width
                        });
                    }else{
                        $('ul.main_menu').css({
                            'width':'auto'
                        });
                    }
                }
            });
            // $(document).ready(function () {
            //  resize_function();

            //  $( window ).resize(function() {
            //      resize_function();
            //  });

            //  function resize_function() {
            //      var window_width = $( window ).width();
            //      var window_height = $( window ).height();
                    
            //      console.log(window_width);

            //      if(window_width < 641){

            //          $('ul.main_menu').css({
            //              'width':window_width,
            //              'height':window_height
            //          }); 

            //          $(".mobilemenu_container img").click(function () {
         //                    $('ul.main_menu').css({'display': 'block'});

         //                    $('.mobilemenu_container_cross').css({'display':'block'});
         //                    $('.mobilemenu_container img').css({'display':'none'});
         //                });

         //                $(".mobilemenu_container_cross img").click(function () {
         //                    $('ul.main_menu').css({'display': 'none'});

         //                    $('.mobilemenu_container_cross').css({'display':'none'});
         //                    $('.mobilemenu_container img').css({'display':'block'});
         //                });                  
            //      }else{

            //          $('ul.main_menu').css({'display': 'block'});
            //          $('ul.main_menu').css({
            //              'width':'auto',
            //              'height':'auto'
            //          }); 

            //          $('.mobilemenu_container img').css({'display':'none'});
            //          $('.mobilemenu_container_cross').css({'display':'none'});
            //      }
            //  }


            // });
        </script>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
