<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Country;

/* @var $this yii\web\View */
/* @var $model backend\models\Institution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="institution-form pane">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>
                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Country</label>
                                    <div class="col-sm-12 input-group">
                                        <?php
                                            echo $form->field($model, 'country')->widget(Select2::classname(), [
                                                'data' => Country::get_all_country_list(),
                                                'options' => ['placeholder' => 'Select a country ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label(false);    
                                        ?>
                                    </div>
                                </div>
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
                                
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>
                                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
                                <div class="form-group text-right">
                                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>