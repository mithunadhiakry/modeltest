<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\bootstrap\ActiveForm;
  $this->title = "Active membership | Model Test";
?>

<div class="inner_container">

  <div class="col-md-offset-3 col-md-6 col-sm-4 col-xs-4"> 
      <div class="login_container_box forgorpassword_container"> 

          <div class="login_header">
              <div class="header_text">
                  Membership Okay
              </div>
              
          </div>
          <div class="logn_box" style="text-align:center;line-height: 30px;">

             Congratulations!  <span style="text-transform:uppercase;"><?= $model->name; ?></span>, Now you are an official member of this website. As a token of our appreciation, we would like to ask you to <strong>complete your full profile</strong>, so that we can give you, <strong>30 POINTS FREE</strong>.
             <br/><br/>
             <a style="color:#f3502b;font-size:20px;" href="http://model-test.com/">Welcome to model-test.com</a>              
          </div>
      </div>
  </div>
</div>