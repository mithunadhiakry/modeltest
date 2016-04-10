<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Category;
use backend\models\Country;

use kartik\widgets\DepDrop;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="subject-form">

                        <?php $form = ActiveForm::begin(); ?>

                            <div class="col-md-12">

                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Country</label>
                                    <div class="col-sm-12 input-group">
                                        <?php
                                            echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                                                'data' => Country::get_all_country_list(),
                                                'options' => ['placeholder' => 'Select a country ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label(false);    
                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Category</label>
                                    <div class="col-sm-12 input-group">

                                        <?php
                                            echo $form->field($model, 'category_id')->widget(DepDrop::classname(), [
                                                'data'=> Category::get_all_parentcategory_list(),
                                                'options' => ['placeholder' => 'Select a category ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                'pluginOptions'=>[
                                                    
                                                    'depends'=>['subject-country_id'],
                                                    'url' => Url::to(['/subject/getchildparentdata']),
                                                    'loadingText' => 'Loading category ...',
                                                ]
                                            ])->label(false);   
                                        ?>

                                        <?php
                                            // echo $form->field($category_subject_rel_model, 'category_id')->widget(Select2::classname(), [
                                            //     'data' => Category::get_all_category_list(),
                                            //     'options' => ['placeholder' => 'Select a category ...','multiple' => true],
                                            //     'pluginOptions' => [
                                            //         'allowClear' => true
                                            //     ],
                                            // ])->label(false);    
                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Sub Category</label>
                                    <div class="col-sm-12 input-group">

                                        <?php
                                            echo $form->field($model, 'sub_category_id')->widget(DepDrop::classname(), [
                                                'data'=> Category::get_all_subcategory_list(),
                                                'options' => ['placeholder' => 'Select a category ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                'pluginOptions'=>[
                                                    
                                                    'depends'=>['subject-category_id'],
                                                    'url' => Url::to(['/subject/getchildsubcategorydata']),
                                                    'loadingText' => 'Loading category ...',
                                                ]
                                            ])->label(false);   
                                        ?>

                                        
                                    </div>
                                </div>

                                <?= $form->field($model, 'subject_name')->textInput(['maxlength' => 255]) ?>

                                <?php
                                    $data = array ('1'=>'Popular Subjects', 
                                                   '2'=>'Other Subjects'
                                                    );
                                    echo $form->field($model, 'for_admission_job')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select']    // options
                                            );
                                ?>


                                <?php
                                    $data = array ('1'=>'Active', 
                                                   '0'=>'Inactive'
                                                    );
                                    echo $form->field($model, 'subject_status')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select Status']    // options
                                            );
                                ?>

                                <div class="form-group">
                                    <div class="col-sm-13 input-group">
                                    <?php
                                        echo $form->field($model, 'exam_time')->widget(TouchSpin::classname(), [
                                            'options'=>['placeholder'=>''],
                                                'pluginOptions' => [
                                                    'verticalbuttons' => true,
                                                    'initval' => 30,
                                                    'min' => 20,
                                                    'max' => 200,
                                                    'buttonup_class' => 'btn btn-primary', 
                                                    'buttondown_class' => 'btn btn-info', 
                                                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                                                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                                                ]
                                        ])
                                    ?>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group text-right">
                                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                </div>
                            </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        <div>
    </div>
</div>