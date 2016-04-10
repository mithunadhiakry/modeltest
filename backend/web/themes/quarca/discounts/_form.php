<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Discounts */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="chapter-form">

                        <?php $form = ActiveForm::begin(); ?>

                            <div class="col-md-12">
                                
                                <?= $form->field($model, 'discounts_name')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'discounts_amount')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'discounts_code')->textInput(['maxlength' => 255]) ?>

                                <?php
                                    $data = array ('January'=>'January', 
                                                   'February'=>'February',
                                                   'March' => 'March',
                                                   'April' => 'April',
                                                   'May' => 'May',
                                                   'June' => 'June',
                                                   'July' => 'July',
                                                   'August' => 'August',
                                                   'September'=> 'September',
                                                   'October' => 'October',
                                                   'November' => 'November',
                                                   'December' => 'December'
                                                    );
                                    echo $form->field($model, 'discounts_month')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select Month']    // options
                                            );
                                ?>
                                <?php
                                    $data_year = array ('2015'=>'2015', 
                                                   '2016'=>'2016',
                                                   '2017' => '2017',
                                                   '2018' => '2018',
                                                   '2019' => '2019',
                                                   '2020' => '2020',
                                                   'July' => 'July'
                                                    );
                                    echo $form->field($model, 'discounts_year')
                                            ->dropDownList(
                                                $data_year,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select Year']    // options
                                            );
                                ?>

                                <?php
                                    $data = array ('Membership'=>'Membership', 
                                                   'Free Points'=>'Free Points'
                                                    );
                                    echo $form->field($model, 'discounts_type')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select Discount Type']    // options
                                            );
                                ?>

                                <?= $form->field($model, 'start_date')->widget(
                                    DatePicker::className(), [
                                        // inline too, not bad
                                        'inline' => false, 
                                        // modify template for custom rendering
                                        //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd'
                                        ]
                                ]);?>

                                <?= $form->field($model, 'end_date')->widget(
                                    DatePicker::className(), [
                                        // inline too, not bad
                                        'inline' => false, 
                                        // modify template for custom rendering
                                        //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd'
                                        ]
                                ]);?>

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

