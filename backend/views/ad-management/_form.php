<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-management-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ad_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ad_identifier')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ad_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
