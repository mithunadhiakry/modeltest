<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login | Model Test';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="inner_container">
  <div class="col-md-offset-4 col-md-4 col-sm-4 col-xs-4"> 
      <div class="login_container_box forgorpassword_container"> 

          <div class="login_header">
              <div class="header_text">
                  LOG IN
              </div>
              
          </div>
          <div class="logn_box">

              <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                                                  
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
                                                                  
                      <?= Html::submitButton('Log in', ['class' => 'login_submit_button onlylogin', 'name' => 'submit']) ?>
                      <button class="fb_signin_button"><img src="<?= Url::base('') ?>/images/fb_login.jpg"></button>
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
</div>

<?php

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

?>