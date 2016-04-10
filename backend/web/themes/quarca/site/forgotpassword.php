<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Forgot password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wrapper">
      
      <div class="member-container">
          
        <div class="member-container-inside">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
              
              <?php
                if(\Yii::$app->getSession()->hasFlash('error')){
                  echo '<p>'.\Yii::$app->getSession()->getFlash('error').'</p>';
                }

                if(\Yii::$app->getSession()->hasFlash('success')){
                  echo '<p>'.\Yii::$app->getSession()->getFlash('success').'</p>';
                }
              ?>

              
              <div class="form-group">
                  <?= $form->field($model, 'email', [
                              'template' => '<div class="row"><div class="col-md-12">{input}{hint}</div></div>',
                              'inputOptions' => [
                                  'placeholder' => $model->getAttributeLabel('Email'),
                              ],
                          ])->textInput(['class'=>'form-control top'])->label(false) ?>
              </div>
              

             <div class="form-group">
                  <?= Html::submitButton('Submit', ['class' => 'btn btn-success btn-block', 'name' => 'login-button']) ?>
              </div>
            <?php ActiveForm::end(); ?>
        </div><!-- member-container-inside -->
      
      <p><small><?= Yii::$app->params['copyright_text']; ?></small></p>
      </div><!-- member-container -->
      
  </div><!-- wrapper -->

<style type="text/css">
  .required::after{
    content: '';
  }
  .checkbox label{
    margin-left: 6px;
  }
</style>