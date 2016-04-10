<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

use frontend\models\Userexamrel;
use frontend\models\User;
use frontend\models\Page;
use frontend\models\PageImageRel;
/* @var $this yii\web\View */
$this->title = 'Welcome';

?>


<!-- Start of home banner -->
        <div class="container">
            <div class="row">
                <div class="home_banner">
    
                <!-- Banner slider -->
                    <div id="wrapper">
                        <div id="carousel">
                            <?php

                                if(!empty($home_banner_r->images)){
                                    foreach($home_banner_r->images as $home_banner){
                            ?>

                                        <div class="bg-color"><img  src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/uploads/<?= $home_banner->image ?>" alt="Banner-image-1"/></div>
                            <?php
                                    }
                                }
                            ?>
                            
                        </div>
                    </div>
                <!-- End of banner slider -->


                <!-- Login container -->
                    <div class="container">
                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <!-- <div class="home_social_container">
                                            <a href="https://www.facebook.com/modeltest4practice">
                                                <span class="facebook_icon">
                                                    <i class="fa fa-facebook"></i>
                                                </span>
                                            </a>
                                            <a href="https://plus.google.com/+Modeltest4Practice">
                                                <span class="googleplus_icon">
                                                    <i class="fa fa-google"></i>
                                                </span>
                                            </a>
                                            <a href="mailto:support@model-test.com">
                                                <span class="mail_icon">
                                                    <i class="fa fa-envelope-o"></i>
                                                </span>
                                            </a>
                                        </div> -->
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-4"></div>  
                                    
                                    <?php 
                                        if(!isset(Yii::$app->user->identity)){
                                    ?>      
                                            <div class="col-md-4 col-sm-4 col-xs-4">                                        
                                                <div class="login_container">                                       
                                                    <div class="login_header">
                                                        <div class="header_text">
                                                            LOG IN
                                                        </div>
                                                        <i class="fa  fa-sign-in login-icon"></i>
                                                    </div>

                                                    <div class="logn_box">

                                                    	<?php $form = ActiveForm::begin(['id' => 'login-form','options' => [

                                                                        'role' => false

                                                                        ]]); ?>
        													
        													<div class="input_field_container">
        														<?= $form->field($model, 'email', [
        								                            'template' => '{input}{error}',
        								                            'inputOptions' => [
        								                                'placeholder' => $model->getAttributeLabel('email'),
        								                            ],
        								                        ])->textInput()->label(false) ?>
        													</div>
        													<div class="input_field_container">
        														<?= $form->field($model, 'password', [
        								                            'template' => '{input}{error}',
        								                            'inputOptions' => [
        								                                'placeholder' => $model->getAttributeLabel('password'),
        								                            ],
        								                        ])->passwordInput()->label(false) ?>
        								                        
        													</div>
        													<div class="input_field_container signin_container">        														
        													    
                                                                <?= Html::submitButton('Log in', ['class' => 'login_submit_button ', 'name' => 'submit']) ?>
                                                                <button class="fb_signin_button"><img  alt="Facebook" src="<?= Url::base('') ?>/images/fb_login.jpg"></button>
                                                            </div>

                                                            <div class="keep_me_forgot_password_container">
            													<div class="input_field_container float-left remember_me">														
                                                                    <input class="float-right" name="LoginForm[rememberMe]" type="checkbox" value="" style="width:11px; margin: -10px 5px 0px 0px; float: left;"><span>Keep me logged in</span>
            													</div>
            													<div class="input_field_container float-right forgot_password">
            														<a href="<?= Url::base('') ?>/site/forgotpassword">Forgot your password ?</a>
            													</div>
                                                            </div>
        													

                                                    	<?php ActiveForm::end(); ?>    

                                                    </div>                                      

                                                </div>
                                            </div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- End of login container -->
                </div>
                
            </div>
        </div>
        <!-- End of home banner -->	


        <!-- Start of home middle section -->
        <div class="container end-container">
            <div class="row">

                <div class="margin-top-30 width100"> 
                    <div class="landing-writeup">                   
                        
                            <?php                           
                                if(!empty($get_page_data->post)){
                                    foreach($get_page_data->post as $post_data){
                                        echo $post_data->desc;
                                    }
                                }
                            ?>                        
                        
                    </div>
                </div>

                <div class="margin-top-30 width100">
                    <div class="col-md-4 col-sm-6 col-xs-12 padding-left-0 padding-left-right-0 content-1">

                        <div class="home-middle-container-header">
                            <div class="middle-box-header">
                                Youtube video channel
                            </div>  
                            <i class="fa fa-youtube-play home-middle-key"></i>
                        </div>  

                        <div class="home-iframe-youtube home-middle-container home-middle-second middle-container-fixed-height padding-0">
                            <iframe src="https://www.youtube.com/embed/v1NjglMPVDI" allowfullscreen></iframe>
                        </div>

                        <!-- <div class="home-middle-container-header margin-top-30">
                            <div class="middle-box-header padding-0">
                                <ul class="nav nav-tabs middle-box-header-tabify">
                                    <li class="active tabify-1"><a data-toggle="tab" href="#tastimonial">tastimonial</a></li>
                                    <i class="fa fa-comments home-middle-key"></i>
                                    <li class="tabify-2"><a data-toggle="tab" href="#facebook">FB fan page</a></li>
                                </ul>
                            </div>  
                            <i class="fa fa-facebook home-middle-key"></i>
                        </div> -->

                        <!-- Avatar-detail-slider -->
                        
                        <div style="float:left; width:100%;position:relative;height:330px;overflow:hidden;">
                            <!-- <div class="home-middle-container-header margin-top-30 tastimonial" style="left:-450px;position:absolute;">
                                <div class="middle-box-header">
                                    Comments
                                </div>  
                                <i class="fa fa-facebook home-middle-key"></i>
                            </div> -->

                            <div class="home-middle-container-header margin-top-30 facebook" style="left:0;position:absolute;">
                                <div class="middle-box-header">
                                    Likes
                                </div>  
                                <i class="fa fa-facebook home-middle-key"></i>
                            </div>

                            <div id="facebook" class="facebook" style="position:absolute;width:396px;left:0px;top:70px;padding:20px;">
                              <h3>Model Test</h3>
                              <div class="fb-like" data-width="275" data-href="https://www.facebook.com/modeltest4practice" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>
                            </div>
                           <!--  <div id="tastimonial" class="tastimonial" style="position:absolute;width:396px;left:-450px;top:70px;padding:20px;overflow-y:auto; overflow-x:hidden;height:260px;">
                                <div class="fb-comments" data-href="http://dcastalia.com/projects/web/model_test" data-width="320" data-numposts="5"></div>
                            </div> -->
                        </div>
                        <!-- end of avater-detail-slider -->
                                        
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 margin-top-30-padding-0 padding-left-right-0 content-2">
                        <div class="home-middle-container-header">
                            <div class="middle-box-header">
                                Recent Test Taker
                            </div>  
                            <i class="fa fa-user home-middle-key"></i>
                        </div>  

                        <div class="home-middle-container home-middle-second middle-container-fixed-height">
                            <!-- <div class="home-middle_date middle-date-top">
                                Today
                            </div> -->
                            <?php
                                $get_recent_test_taker = Userexamrel::getrecent_testtaker();
                                
                                foreach($get_recent_test_taker as $latest_taker){                                
                                    $question_list = \yii\helpers\Json::decode($latest_taker->exam_questions);
                                    
                                    $total_question = count($question_list);
                                    
                                    $correct = 0;
                                    $answered = 0;
                                    $Percentage = 0;

                                    if(isset($question_list)){

                                        foreach ($question_list as $question) {
                                            if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
                                                $answered++;

                                                if($question['is_correct'] == $question['answer_id']){
                                                    $correct++;
                                                }
                                            }
                                            
                                        }

                                        if(!empty($total_question)){
                                            $Percentage = round(($correct*100)/$total_question,2);
                                        }else{
                                            $Percentage = 0;
                                        }
                                        
                                    }
                                    

                                    $user_data = User::find()
                                                    ->where(['id' => $latest_taker->user_id])
                                                    ->one();

                                    
                                ?>
                                        <div class="home-middle-second-container">
                                            <div class="home-middle-second-avater">
                                                <?php
                                                    if(!empty($user_data->image)){
                                                ?>
                                                    <img  alt="Student" src="<?= Url::base('') ?>/user_img/<?= $user_data->image ?>">
                                                <?php  }else{ ?>
                                                    <img  alt="Student" src="<?= Url::base('') ?>/images/avatar-test-taker.jpg">
                                                <?php  }  ?>
                                                
                                            </div>
                                            <div class="home-middle-second-content">
                                                <div class="home-middle-second-name">
                                                   <?= $Percentage ?>% Score
                                                     
                                                   </div>
                                                <div class="home-middle-second-marks-container">
                                                    <div class="marks"><?= $user_data->name; ?></div>
                                                    <div class="time">@ <?= date_format(date_create($latest_taker->created_at), 'dS F Y h:m:s'); ?> </div>
                                                </div>

                                            </div>
                                        </div>
                                <?php
                                    
                                }
                            ?>
                           

                            
                        </div>


                        <div class="home-middle-container-header margin-top-30">
                            <div class="middle-box-header">
                                Latest Added Model Test
                            </div> 
                            <div class="latest-added-model-test-icon"> 
                                <img  alt="Model Test" src="<?= Url::base('') ?>/images/exam.png">
                            </div>
                        </div>

                        <div class="home-middle-container middle-container-fixed-height">
                            
                            <?php
                                if(!empty($latest_exam_list_r)){
                                    foreach($latest_exam_list_r as $latest_exam_list){
                            ?>

                                        <div class="home-middle-box">
                                            
                                            <div class="home-middle-text">
                                                <?php
                                                    if(isset(\Yii::$app->user->identity->user_type) && \Yii::$app->user->identity->user_type == 'student' && $latest_exam_list->created_by == \Yii::$app->user->identity->institution_id ):
                                                        echo $latest_exam_list->question_set_name;
                                                    else:
                                                        echo $latest_exam_list->alternate_name?$latest_exam_list->alternate_name:$latest_exam_list->question_set_name;
                                                    endif;
                                                ?>
                                               
                                                <span class="category_name">
                                                    (<?php
                                                        if($latest_exam_list->category_id == '56'){
                                                           echo $latest_exam_list->subcat_name->category_name;
                                                        }else{
                                                           echo $latest_exam_list->cat_name->category_name;
                                                        }
                                                    ?>)
                                                </span>
                                            </div>
                                           
                                            <a data-id="<?=$latest_exam_list->question_set_id;?>" class="home-middle-start-exam question_set" >Start exam</a>
                                        </div>
                            <?php
                                    }

                                }

                            ?>
                            

                           

                            
                        </div>  


                    </div>

                    
                    <div class="col-md-4 col-sm-6 col-xs-12 padding-right-0 margin-top-30-padding-0 ">
                        <?php 
                            if(!isset(Yii::$app->user->identity)){
                        ?>


                            

                               <!-- Button trigger modal -->
<button style="display:none;" type="button" class="signup_popup btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
 
</button>

<!-- Modal -->
<div class="modal fade custom-modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="myModalLabel">SIGN UP</h4>
      </div>
      <div class="modal-body">
            
            <p class="content1">
                Hey, you are almost done!
            </p>
            <p class="content2">
                We have sent a confirmation email to your registered email address.
            </p>
            <p class="content2">
                All you need to click on the apt link
            </p>
            <p class="content3">
                <strong>Note:</strong>  Sometimes emails tend to go to the wrong box lika as Junk/Spam, So do not forgot to take a peek, if cannot see it your inbox folder.
            </p>

      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>



                                <?php
    								if(\Yii::$app->getSession()->hasFlash('success')){
    							?>

                                      <?php
                                            $this->registerJs("

                                                $(window).load(function(){

                                                   $('.signup_popup').click();

                                                });
                                                
                                            ", yii\web\View::POS_READY, "registration_alert");

                                        ?>

                                     <?php
                                            if(!empty($advertisement_r)){
                                                $count = 1;
                                                foreach($advertisement_r as $advertisement){
                                        ?>
                                                
                                                    <div class="advertisement <?php if($count != 1){ echo 'margin-top-30';} ?> ">
                                                        <a href="<?= $advertisement->url; ?>" target="_blank">
                                                            <img  alt="Advertisement" src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement->image; ?>">
                                                        </a>
                                                    </div>

                                        <?php
                                                $count++;
                                                    }
                                                }
                                        ?>
    							

    							<?php
    								}else{
    							?>

                                    <div class="home-middle-container-header">
                                        <div class="middle-box-header home-signup-header">
                                            Sign Up
                                        </div>  
                                        <i class="fa fa-cloud-upload home-middle-key home-signup"></i>
                                    </div>  

                                    <div class="home-middle-container home-sigup-section">
    									<?php $form = ActiveForm::begin(['id' => 'signup-form','options' => [

                                                                        'role' => false

                                                                        ]]); ?>
    										<div class="home-signup-container">
    											<label>Name</label>
    											<?= $form->field($signup_model, 'name', [
    					                            'template' => '{input}{error}',
    					                        ])->textInput()->label(false) ?>
    										</div>

    										<div class="home-signup-container">
    											<label>Email</label>
    											<?= $form->field($signup_model, 'email', [
    					                            'template' => '{input}{error}',
    					                        ])->textInput()->label(false) ?>
    										</div>

    										<div class="home-signup-container width48">
    											<label>Password</label>
    											<?= $form->field($signup_model, 'password', [
    					                            'template' => '{input}{error}',
    					                        ])->passwordInput()->label(false) ?>
    										</div>

                                            <div class="home-signup-container width48 floatright">
                                                <label>Repeat password</label>
                                                <?= $form->field($signup_model, 'password_repeat', [
                                                    'template' => '{input}{error}',
                                                ])->passwordInput()->label(false) ?>
                                            </div>

    										<div class="home-signup-container">
    											<label>Phone</label>
    											<?= $form->field($signup_model, 'phone', [
    					                            'template' => '{input}{error}',
    					                        ])->textInput()->label(false) ?>
    										</div>


    										<div class="home-signup-container">
    											<div class="home-signup-mobile">
    												<label>Authority</label>
    												<?php
    							                        $data = array ('student'=>'Student', 
    							                                       'institution'=>'Institution'
    							                                        );
    							                        echo $form->field($signup_model, 'user_type')
    							                                ->dropDownList(
    							                                    $data,           // Flat array ('id'=>'label')
    							                                    ['prompt'=>'Select authority']    // options
    							                                )->label(false);
    							                        

    							                    ?>
    											</div>

    											<div class="home-signup-mobile home-signup-authority institution_open_close">
    												<label>Institution</label>
    												<?= $form->field($signup_model, 'institution', [
    						                            'template' => '{input}{error}',
    						                        ])->textInput()->label(false) ?>
    											</div>

    				                        </div>
    										
    				                        <?= Html::submitButton('Sign up', ['class' => 'login_submit_button signup', 'name' => 'Sign up']) ?>
    									<?php ActiveForm::end(); ?>
    									<div class="home-signup-container home-terms-policy">
    										By clicking sign up you agree with our<br/> <a href="<?= Url::toRoute(['page/terms-of-use']); ?>">Terms Of Use</a> & <a href="<?= Url::toRoute(['page/privacy-policy']); ?>">Privacy Policies</a>
    									</div>
    							<?php
    								}
    							?>
                            </div> 



                        <?php }else{

                        ?>
                        <?php
                            if(!empty($advertisement_r)){
                                $count = 1;
                                foreach($advertisement_r as $advertisement){
                        ?>
                                
                                    <div class="advertisement <?php if($count != 1){ echo 'margin-top-30';} ?> ">
                                        <a href="<?= $advertisement->url; ?>" target="_blank">
                                            <img  alt="Advertisement" src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement->image; ?>">
                                        </a>
                                    </div>

                        <?php
                                $count++;
                                    }
                                }
                        ?>
                        <?php
                         } ?>                     
                    </div>
                </div>


            </div>
        </div>
        <!-- End of home middle section -->
        

        <!-- Start of footer section -->

        <div class="container-fluid">
            <?php
                if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){
            ?>
                    
                    <div class="row">
                        <div class="inner_footer_container">
                            <div class="container">
                                <div class="footer_left">
                                    <span class="all_rights_reserve">
                                        All right reserved @ modeltest.
                                    </span>
                                    <a class="developer_company" href="#">
                                         Powered by Abedon. 
                                    </a>
                                </div>

                                <div class="footer_right">
                                    <ul>
                                        <li>
                                            <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Exam Centre</a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::toRoute(['page/membership']); ?>">Membership</a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::toRoute(['page/how-to-pay']); ?>">How to Pay</a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::toRoute(['page/discounts']); ?>">Discounts</a>
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

            <?php }else{ ?>
                    
                    <div class="row footer-background">         
                        <div class="container">
                            <div class="row">
                                <footer class="col-md-12">
                                    <div class="row">

                                        <div class="p_footer_container">
                                            <div class="footer_right_side_container">
                                                <div class="footer_menu_container">
                                                    <div class="footer_menu">
                                                        <h2><a class="remove_cursor" href="#">Exam Centre</a></h2>
                                                        <ul class="f_menu">
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Class VIII - XII</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">university admission</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">engineering admission</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">medical admission</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">BCS Preliminary Exam</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Bank Job</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">Teacher's Job</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['exam/examcenter']); ?>">All kind of Govt. Job</a>
                                                            </li>                                       
                                                        </ul>

                                                    </div>
                                                    <div class="footer-border"></div>

                                                    <div class="footer_menu">
                                                        <h2><a class="remove_cursor" href="#">Membership</a></h2>
                                                        <ul class="f_menu">
                                                            <li>
                                                                <a href="<?= Url::to(['page/points-rewards']); ?>">Points & Rewards</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['page/how-to-pay']); ?>">How To Pay</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['page/discounts']); ?>">Discounts</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['page/faq']); ?>">FAQ</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="footer-border"></div>

                                                    <div class="footer_menu">
                                                        <h2><a class="remove_cursor" href="#">For Institutes</a></h2>
                                                        <ul class="f_menu">
                                                            <li>
                                                                <a href="<?= Url::to(['site/login']); ?>">Batches</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['site/login']); ?>">Students</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['site/login']); ?>">How To Assign</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::to(['site/login']); ?>">How To Create Exam</a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                    <div class="footer-border"></div>

                                                    <div class="footer_menu news-events">
                                                        <h2><a class="remove_cursor" href="#">For Students</a></h2>
                                                        <ul class="f_menu">
                                                            <li>
                                                                <a href="<?= Url::toRoute(['user/myexam']); ?>">My Model Test</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['user/history']); ?>">History</a>
                                                            </li>
                                                            
                                                            <li>
                                                                <a href="<?= Url::toRoute(['user/account']); ?>">Accounts</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['page/instruction']); ?>">Instructions</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="footer-border"></div>

                                                    <div class="footer_menu">
                                                        <h2><a class="remove_cursor" href="#">About</a></h2>
                                                        <ul class="f_menu">
                                                            <li>
                                                                <a href="<?= Url::toRoute(['page/contact-us']); ?>">Contact Us</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['page/terms-of-use']); ?>">Terms Of Use</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= Url::toRoute(['page/privacy-policy']); ?>">Privacy Policies</a>
                                                            </li>
                                                            
                                                            <li>
                                                                <a href="<?= Url::toRoute(['article/index']); ?>">Articles</a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                    <div class="footer-border"></div>

                                                    <div class="footer_menu">
                                                        <a class="remove_cursor footer_logo" href="http://model-test.com/"><img src="<?= Url::base('') ?>/images/logo.png" width="150" height="40" alt="Logo"></a>
                                                        <ul class="f_menu abedon_enterprise">
                                                            <li>
                                                               Powered by Abedon.
                                                            </li>
                                                            <li>
                                                                Copyright&copy; 2016
                                                            </li>
                                                            <li>
                                                                All right reserved
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>

            <?php } ?>
            
        </div>

        <!-- End of footer section -->

        <div class="modal fade" id="instruction_modal_model_test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">

            <div class="exam_instruction_container">
            
                <!-- <div class="model_test_set_id"></div> -->
                <?php                           
                    if(!empty($instruction_data->post)){
                        foreach($instruction_data->post as $post_data){
                            echo $post_data->desc;
                        }
                    }
                ?>
           </div>


        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
            <div class="start_exam_loader">
                <div class="css_loader_container_wrap">
                    <div class="css_loader_container">
                        <div class="cssload-loader"></div>
                    </div>
                </div>
            </div>
            <div class="start_exam_popup_container">
                <div class="width100 start_exam_checkbox">
                    <input type="checkbox" name="tick_to_make" id="tick_to_make_model_test">                    
                    <label for="tick_to_make_model_test">Tick to make sure you read & understand 'Instructions'.</label>
                </div>
                <div class="width100 start_exam_checkbox fb_share_button_for_exam">
                    <input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_model_test_facebook">
                    <label for="share_report_in_model_test_facebook">Share my report to my Facebook's personal wall, at the end of my exam.</label>
                </div>
                <div class="width100">
                    <br/>
                    Press <strong>Start Exam</strong> button  to begin the exam. All the best.
                </div>
            </div>
            <button type="button" class="btn btn-success start_exam_btn_model_test start_exam_btn">Start Exam</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal -->

<?php

    $this->registerJs("

        var question_set = '';
        $('.question_set').on('click',function (e) {
            question_set = $(this).attr('data-id');


            //$('.model_test_set_id').html(question_set);
            $('#instruction_modal_model_test').modal('show');

            return false;
        });



        $('.start_exam_btn_model_test').on('click',function(){

            if($('#share_report_in_model_test_facebook').prop('checked') == true){
                var share_facebook_report = 1;
            }else{
                var share_facebook_report = 0;
            }

            
            if($('#tick_to_make_model_test').prop('checked') == true){
            
                $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : '".Url::toRoute('rest/start_exam_check_model_test')."',
                    data: {share_facebook_report:share_facebook_report,question_set:question_set},
                    beforeSend : function( request ){
                        $('#instruction_modal_model_test .css_loader_container_wrap').fadeIn();
                    },
                    success : function( data )
                        {   
                            $('#instruction_modal_model_test .css_loader_container_wrap').fadeOut();
                            if(data.result == 'success'){
                                window.location = data.redirect_url;
                            }
                            else if(data.result == 'login_error'){
                                window.location = data.redirect_url;
                            }else if(data.result == 'error'){
                                
                                BootstrapDialog.alert({
                                     title: 'WARNING',
                                     'message': data.message
                                });
                            }

                            
                        }
                });

            }else{
                
                BootstrapDialog.alert({
                         title: 'WARNING',
                         'message': 'Please read the instruction carefully'
                    });
            }
            
            
            return false;
        });


    ", yii\web\View::POS_READY, "modeltest");


		if(!isset($signup_model->user_type)){
			$signup_modeluser_type = 'na';
		}else{
			$signup_modeluser_type = $signup_model->user_type;
		}
		$this->registerJs("

			var usertype_institution = '".$signup_modeluser_type."';

			if(usertype_institution == 'institution'){
				$('.institution_open_close').show();
			}
            $(document).delegate('#user-user_type', 'change', function() { 
                var user_type = $(this).val();
                if(user_type == 'institution'){
					$('.institution_open_close').show();
                }else{
                	$('.institution_open_close').hide();
                }


                return false;
            });
    ", yii\web\View::POS_READY, 'authority_type');

        $this->registerJs("
        // This is called with the results from from FB.getLoginStatus().
          function statusChangeCallback(response) {
            console.log('statusChangeCallback');
            console.log(response);

            if (response.status === 'connected') {
              // Logged into your app and Facebook.
              testAPI();
            } else if (response.status === 'not_authorized') {
              // The person is logged into Facebook, but not your app.
              document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
            } else {
              // The person is not logged into Facebook, so we're not sure if
              // they are logged into this app or not.
              document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
            }
          }

          function checkLoginState() {
            FB.login(function(response) {
               if (response.authResponse) {
                 statusChangeCallback(response);
               } else {
                 console.log('User cancelled login or did not fully authorize.');
               }
            },{scope:'public_profile,email,user_location'});
          }

          window.fbAsyncInit = function() {
          FB.init({
            appId      : '709957295722222',
            cookie     : true,  // enable cookies to allow the server to access 
                                // the session
            xfbml      : true,  // parse social plugins on this page
            version    : 'v2.2' // use version 2.2
          });

          };

          // Load the SDK asynchronously
          (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = '//connect.facebook.net/en_US/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));


          function testAPI() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me?fields=id,name,email', function(response) {
              console.log(response);

                var jqxhr = $.post( '".Url::toRoute('site/login_with_fb')."', { type : 'fbLogin', data : response }, function(resp) {
                    var resp = jQuery.parseJSON( resp );
                    if(resp.result=='success'){
                        location.href = resp.url;
                    }else{
                        console.log(resp.msg);
                        
                    }

                })
                  .fail(function() {
                    alert( 'error' );
                  });

            });
          }   


          $('.fb_signin_button').on('click',function(){

                checkLoginState();
                return false;
          });    
    ", yii\web\View::POS_END, 'fb_login');

        $this->registerJs("

            // show_first(30000);

            // function show_second(time){
            //     setTimeout(function(){
            //         $('.tastimonial').css('overflow','hidden');
            //         $('.tastimonial').animate({'left':'-450px'},1000);
            //         $('.facebook').animate({'left':'0'},1000);

            //         show_first(30000);
            //     },time);
            // }
            // function show_first(time){
            //     setTimeout(function(){
            //         $('.tastimonial').animate({'left':'0'},1000,function(){
            //             $('.tastimonial').css('overflow','auto');
            //         });
            //         $('.facebook').animate({'left':'-450px'},1000);

            //         show_second(10000);
            //     },time);
            // }
            
    ", yii\web\View::POS_READY, 'toggle_fb');

        $this->registerJs("

            $.mask.definitions['~']='[(0)]';
            $('#user-phone').mask('(+88)-~999-9999-999');

        ", yii\web\View::POS_READY, 'mobile_number_validation');  
	?>