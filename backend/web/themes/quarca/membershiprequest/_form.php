<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Membershiprequest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12">
    <div class="pane" style="float:left; width:100%;">
        <div class="page-form">

                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>

                    <?= $form->field($model, 'invoice_id')->textInput(['readonly' => true]) ?>

                    <?= $form->field($model, 'payment_type')->textInput(['readonly' => true]) ?>

                    <?php
                        $data = array ('1'=>'Paid', 
                                       '0'=>'Unpaid'
                                        );
                        echo $form->field($model, 'status')
                                ->dropDownList(
                                    $data,           // Flat array ('id'=>'label')
                                    ['prompt'=>'Select Status']    // options
                                );
                    ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
