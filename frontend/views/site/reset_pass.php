<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;

	$this->title = "Reset Password | Model Test";
?>

<div class="inner_container">
  <div class="col-md-offset-3 col-md-6 col-sm-4 col-xs-4"> 
      <div class="login_container_box forgorpassword_container"> 

          <div class="login_header">
              <div class="header_text">
                 Choose e new password
              </div>
              
          </div>
          <div class="logn_box">

              <?php $form = ActiveForm::begin(['id' => 'form-reset']); ?>
                                                                 
                  <div class="input_field_container">
                  	<?= $form->field($model, 'password', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Password'),
                            ],
                        ])->passwordInput(['class'=>'form-control top'])->label(false) ?>
                      
                  </div>

                  <div class="input_field_container">
                     
                      <?= $form->field($model, 'repeat_password', [
                            'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                            'inputOptions' => [
                                'placeholder' => $model->getAttributeLabel('Repeat Password'),
                            ],
                        ])->passwordInput(['class'=>'form-control top'])->label(false) ?>
                  </div>
                  
                  <div class="input_field_container">
                      <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>             
                  </div>
                  
                  
                <?php ActiveForm::end(); ?>
          </div>
      </div>
  </div>
</div>

