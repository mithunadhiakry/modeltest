<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Country;
use backend\models\Countrycategoryrel;
use backend\models\Category;

use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="category-form pane">

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
                                    <label class="control-label" for="userfront-country">Parent Name</label>
                                    <div class="col-sm-12 input-group">
                              
                                        <?php
                                            echo $form->field($model, 'parent_id')->widget(DepDrop::classname(), [
                                                'data'=> Category::get_all_parentcategory_list(),
                                                'options' => ['placeholder' => 'Select a parent ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                                'pluginOptions'=>[
                                                    
                                                    'depends'=>['category-country_id'],
                                                    'url' => Url::to(['/category/getparentofcountry']),
                                                    'loadingText' => 'Loading parent ...',
                                                ]
                                            ])->label(false);   
                                        ?>
                                    </div>
                                </div>

                                <?= $form->field($model, 'category_name')->textInput(['maxlength' => 255]) ?>
    
                                <?php
                                    $data = array ('1'=>'Active', 
                                                   '0'=>'Inactive'
                                                    );
                                    echo $form->field($model, 'category_status')
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