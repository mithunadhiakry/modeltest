<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use frontend\models\User;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        $this->registerMetaTag(['property'=>'fb:admins','content' => '100001137957498']);
    ?>
    <?= Html::csrfMetaTags() ?>
    <title>Welcome to Model Test</title>
    <?php $this->head() ?>
	
	<link rel="icon" type="image/png" href="<?= Url::base('') ?>/images/favicon.png">
    <?php  

        $this->registerCssFile("http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css", [
              'media' => 'all',
        ], 'font-awesome');

        $this->registerCssFile(Url::base('')."/css/bootstrap.css", [
              'media' => 'all',
        ], 'bootstrap');
        
        $this->registerCssFile(Url::base('')."/css/styles.css", [
              'media' => 'all',
        ], 'style');

          $this->registerCssFile(Url::base('')."/css/contact-buttons.css", [
              'media' => 'all',
        ], 'contact-buttons');

        $this->registerCssFile(Url::base('')."/css/bxslider.css", [
              'media' => 'all',
        ], 'bxslider');
    ?>
	
	
	<?= $this->registerJsFile(Url::base()."/js/jquery.bxslider.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?= $this->registerJsFile(Url::base()."/js/bootstrap.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?= $this->registerJsFile(Url::base()."/js/jquery.carouFredSel-packed.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?= $this->registerJsFile(Url::base()."/js/bootstrap-dialog.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?= $this->registerJsFile(Url::base()."/js/jquery.maskedinput.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
	<?= $this->registerJsFile(Url::base()."/js/jquery.contact-buttons.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>    
</head>
	<body>
	    <?php $this->beginBody() ?>

	    <?php
	        if(isset(Yii::$app->user->identity->id)){
	            $user_data = User::find()->where(['id' => Yii::$app->user->identity->id ])->one();
	        }
	    ?>
		
		<!-- Facebook plaging -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=709957295722222&version=v2.4";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<!-- Facebook plaging -->


		<!-- Start of header -->
		<div class="container-fluid">
			<div class="row">
				<div class="header_container">
					<div class="container">
						<div class="row">
							<div class="col-md-2 col-sm-3 col-xs-4">
								<div class="row">
									<a href="http://model-test.com/" class="logo">
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
												<span class="cart_number"><span>0</span> Items(s)</span>
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
										<ul class="main_menu">
											<li>
												<a href="#"><img  alt="Model Test" src="<?= Url::base('') ?>/images/home.png" ></a>
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
	                                                    <a href="<?= Url::toRoute(['page/points-rewards']) ?>">Point & Rewards</a>
	                                                </li>
	                                                
	                                               <!--  <li>
	                                                    <a href="<?= Url::toRoute(['user/history']); ?>">History</a>
	                                                </li> -->
	                                               
	                                                <li class="text_transform_lowercase inner_menu_left_border">
	                                                    <a href="<?= Url::toRoute(['dashboard/index']); ?>">
	                                                        <span class="avater">
	                                                            <?php
	                                                                if(!empty($user_data->image)){
	                                                            ?>
	                                                                    <img  alt="Student" src="<?= Url::base('') ?>/user_img/<?= $user_data->image; ?>">
	                                                            <?php   }else{ ?>
	                                                                <img  alt="Student" src="<?= Url::base('') ?>/images/avatar-test-taker.jpg">
	                                                            <?php } ?>
	                                                            
	                                                        </span>
	                                                        <?= $user_data->name; ?> 
	                                                    </a>
	                                                </li>
	                                                <li class="text_transform_lowercase">
	                                                    <a class="dashboard_account" href="#"><img  alt="Setting" src="<?= Url::base('') ?>/images/settings.png" >

	                                                    </a>

	                                                    
	                                                    <ul class="signout_setting dashboard_signout_setting">
	                                                        
	                                                        <li>
	                                                            <a href="<?= Url::toRoute(['user/view?tab=points_payments']); ?>">Account</a>
	                                                        </li>

	                                                        <li>
	                                                            <a  data-method="post"  href="<?= Url::toRoute(['site/logout']); ?>">Signout</a>
	                                                        </li>

	                                                    </ul>
	                                                </li>

	                                        <?php }else{ ?>
	                                          		
													<li>
														<a href="<?= Url::toRoute(['exam/examcenter']); ?>">Exam Centre</a>
													</li>
													<li>
														<a href="<?= Url::toRoute(['page/membership']); ?>">Membership</a>
														
													</li>
													<li>
														<a href="<?= Url::to(['page/points-rewards']); ?>">Points & Rewards</a>
													</li>
													
													<li>
														<a href="<?= Url::toRoute(['page/about-us']); ?>">About</a>
													</li>

	                                        <?php } ?>
											
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

		<?php
			$this->registerJs("


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

			", yii\web\View::POS_READY, 'resize_function');


			$this->registerJs("
				
				$(document).ready(function () {
					$('#carousel').carouFredSel({
						width: $(window).width(),
						height: $(window).height(),
						scroll : { fx : 'uncover-fade',
							duration : 800
						 },
						auto: {
		            	timeoutDuration: 15000},
						align: false,
						items: {
							visible: 1,
							width: 'variable',
							height: 'variable'
						}
					});


					$(window).resize(function() {
						var newCss = {
							width: $(window).width(),
							height: $(window).height()
						};
						$('#carousel').css( 'width', newCss.width*4 );
						$('#carousel').parent().css( newCss );
						$('#carousel div').css( newCss );
					}).resize();


					$('.slider2').bxSlider({
					    slideWidth: 300,
					    minSlides: 1,
					    maxSlides: 1,
					    slideMargin: 10
					  });
				});

			", yii\web\View::POS_READY, 'carousel');

		?>

		
	<!-- End of Slider-script -->


<?php

	$this->registerJs("

	 $.contactButtons({
	  buttons : {
	    'facebook':   { class: 'facebook', use: true, link: 'https://www.facebook.com/modeltest4practice' },
	    'google':     { class: 'gplus',    use: true, link: 'https://plus.google.com/+Modeltest4Practice' },
	    'twitter':   { class: 'twitter',      use: true, link: 'https://twitter.com/ModelTestDotComd', icon: 'twitter', title: 'Visit on Twitter' },
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