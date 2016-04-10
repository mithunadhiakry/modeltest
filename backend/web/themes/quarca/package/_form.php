<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Package */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="package-form">
                        <?php $form = ActiveForm::begin(); ?>


                             <div class="col-md-6">

                                <?= $form->field($model, 'package_type')->textInput(['maxlength' => 255]); ?>                                

                                <?= $form->field($model, 'price_bd')->textInput(['maxlength' => 255]) ?>

                                <?= $form->field($model, 'duration')->textInput(['maxlength' => 255]) ?>

                                <?php
                                    $data = array ('Yes'=>'Yes', 
                                                   'No'=>'No'
                                                    );
                                    echo $form->field($model, 'share_exam')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select']    // options
                                            );
                                ?>

                            </div>

                            <div class="col-md-6">
                                
                                
                                
                                <?php
                                    $data = array ('Yes'=>'Yes', 
                                                   'No'=>'No'
                                                    );
                                    echo $form->field($model, 'save_exam')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select']    // options
                                            );
                                ?>

                                <?php
                                    $data = array ('Yes'=>'Yes', 
                                                   'No'=>'No'
                                                    );
                                    echo $form->field($model, 'advanced_reporting')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select']    // options
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