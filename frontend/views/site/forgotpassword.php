<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\bootstrap\ActiveForm;
  $this->title = "Forgot Password | Model Test";
?>

<div class="inner_container">
  <div class="col-md-offset-3 col-md-6 col-sm-4 col-xs-4"> 

      <div class="login_container_box forgorpassword_container"> 

          <div class="login_header">
              <div class="header_text" >
                 FORGOT PASSWORD ?
              </div>

              <div class="forgot_password_body">
                Don’t worry. You just need to put your registered email address in the box below. We
                will send you an email with a link for re-setting your password. That's it!
              </div>
              
          </div>
          <div class="logn_box">

              <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?php
                    if(\Yii::$app->getSession()->hasFlash('error')){
                      echo '<p style="color:#f3502b;font-size:14px;">'.\Yii::$app->getSession()->getFlash('error').'</p>';
                    }

                    if(\Yii::$app->getSession()->hasFlash('success')){
                      echo '<p style="color:#88c150;font-size:14px;">'.\Yii::$app->getSession()->getFlash('success').'</p>';
                    }
                ?>                                                                
                  <div class="input_field_container">
                      <?= $form->field($model, 'email', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Email address'),
                            ],
                        ])->textInput(['class'=>'form-control top'])->label(false) ?>
                  </div>
                  
                  <div class="forgotpassword_submit">
                      <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-block login_submit_button', 'name' => 'login-button']) ?>             
                  </div>
                  
                  
                <?php ActiveForm::end(); ?>
          </div>
      </div>
  </div>
</div>