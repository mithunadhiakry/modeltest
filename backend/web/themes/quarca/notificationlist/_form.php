<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\NotificationList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-6">
<div class="pane" style="float:left; width:100%;">
    <div class="page-form">
        
        <div class="notification-list-form">

            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'desc')->textInput(['maxlength' => 255]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
                
    </div>
</div>
</div>

