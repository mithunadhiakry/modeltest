<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model institution\models\Courses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'course_name')->textInput(['maxlength' => 255]) ?>

    <?php
        $data = array ('1'=>'Active', 
                       '0'=>'Inactive'
                        );
        echo $form->field($model, 'status')
                ->dropDownList(
                    $data,           // Flat array ('id'=>'label')
                    ['prompt'=>'Select Status']    // options
                );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
