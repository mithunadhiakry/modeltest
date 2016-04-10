<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>&nbsp;</p>
<div class="wrapper">
      
      <div class="member-container">
          
        <div class="member-container-inside">

			<?php $form = ActiveForm::begin(['id' => 'form-reset']); ?>

			    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]); ?>
			    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255]); ?>


			    <div class="form-group">
			        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
			    </div>
			<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>