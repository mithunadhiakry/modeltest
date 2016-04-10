<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

use backend\models\Subject;
use backend\models\Country;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Chapter */
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
                                                    
                                                    'depends'=>['chapter-country_id'],
                                                    'url' => Url::to(['/subject/getchildparentdata']),
                                                    'loadingText' => 'Loading category ...',
                                                ]
                                            ])->label(false);   
                                        ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Sub Category</label>
                                    <div class="col-sm-12 input-group">

                                        <?php
                                            echo $form->field($model, 'sub_category_id')->widget(DepDrop::classname(), [
                                                'data'=> Category::get_all_subcategory_list(),
                                                'options' => ['placeholder' => 'Select a sub category ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                'pluginOptions'=>[
                                                    
                                                    'depends'=>['chapter-category_id'],
                                                    'url' => Url::to(['/subject/getchildsubcategorydata']),
                                                    'loadingText' => 'Loading sub category ...',
                                                ]
                                            ])->label(false);   
                                        ?>

                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="userfront-country">Subject</label>
                                    <div class="col-sm-12 input-group">

                                        <?php

                                            echo $form->field($model, 'subject_id')->widget(DepDrop::classname(), [
                                                'data'=> Subject::get_all_subject_list(),
                                                'options' => ['placeholder' => 'Select a chapter ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                'pluginOptions'=>[
                                                    
                                                    'depends'=>['chapter-sub_category_id'],
                                                    'url' => Url::to(['/chapter/getchildsubjectdata']),
                                                    'loadingText' => 'Loading chapter ...',
                                                ]
                                            ])->label(false);   
                                        ?>

                                        
                                    </div>
                                </div>
                                
                                <?= $form->field($model, 'chaper_name')->textInput(['maxlength' => 255]) ?>

                                <?php
                                    $data = array ('1'=>'Active', 
                                                   '0'=>'Inactive'
                                                    );
                                    echo $form->field($model, 'chapter_status')
                                            ->dropDownList(
                                                $data,           // Flat array ('id'=>'label')
                                                ['prompt'=>'Select Status']    // options
                                            );
                                ?>

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