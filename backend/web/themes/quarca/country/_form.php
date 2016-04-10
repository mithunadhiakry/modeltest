<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="country-form">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="col-md-12">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
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
                                <div class="form-group text-right">
                                    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>