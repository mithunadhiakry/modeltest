<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Membershiprequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="membershiprequest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'invoice_id')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'payment_type')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
