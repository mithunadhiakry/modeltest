<?php

use  yii\web\Session;

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

use \kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

use kartik\widgets\DepDrop;

$total_ans = 0;

    $session = Yii::$app->session;


?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="question-form">

                        <?php $form = ActiveForm::begin(['id'=>'question-form'/*,
                                                        'enableClientValidation' => true,
                                                        'enableAjaxValidation' => true,
                                                        'options' => [
                                                            'validateOnSubmit' => true
                                                            ],*/
                                                        ]); 
                        ?>
                        

                        <div class="col-md-6">
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
                        <div class="col-md-12">
                            <?= $form->field($model, 'details')->textarea(['rows' => '2','id'=>'editor2']) ?>
                        
                         </div>
                        <?php
                            if(\Yii::$app->getSession()->getFlash('error')){
                        ?>
                            <div class="col-md-12">
                                <p style="color:red;"><?= \Yii::$app->getSession()->getFlash('error'); ?></p>
                            </div>
                        <?php
                            }
                        ?>
                        <div class="col-md-12 ans_container">
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 8, // the maximum times, an element can be cloned (default 999)
                            'min' => 4, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $ans_model[0],
                            'formId' => 'question-form',
                            'formFields' => [
                                'answer',
                                'is_correct',
                            ],
                        ]); ?>

                        <div class="container-items"><!-- widgetContainer -->


                            
                            <?php foreach ($ans_model as $i => $ans_modelsss): ?>
                                <div class="item panel panel-default"><!-- widgetBody -->
                                    
                                    <div class="panel-body">
                                        <?php
                                            // necessary for update action.
                                            if (! $ans_modelsss->isNewRecord) {
                                                echo Html::activeHiddenInput($ans_modelsss, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <?= $form->field($ans_modelsss, "[{$i}]answer")->textArea(['id'=>'anseditor'.$i,'class'=>'anseditor']) ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $form->field($ans_modelsss, "[{$i}]is_correct")->checkBox(['checked'=>'checked']) ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" class="remove-item btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                        </div><!-- .row -->

                                    </div>
                                </div>

                            <?php 
                                $this->registerJs('
            
                                CKEDITOR.replace( "anseditor'.$i.'", {
                                     customConfig: "'.Url::base().'/ckeditor/config/ans/config.js",
                                     filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                                     filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                                     filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                                     filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                                     filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                                     filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
                                });


                            ', yii\web\View::POS_READY, 'anseditor'.$i);
                            endforeach; ?>

                        </div>
                        <div class="panel-heading col-md-12">
                            <div class="pull-right">
                                <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <?php DynamicFormWidget::end(); ?>


                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success question_sub_btn' : 'btn btn-primary question_sub_btn']) ?>
                                
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>



<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor2", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });


    ', yii\web\View::POS_READY, 'ck_editor_post');

    $this->registerJs('
            
            $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
                item = $(item).find(".anseditor").attr("id");

                CKEDITOR.replace( item, {
                    customConfig: "'.Url::base().'/ckeditor/config/ans/config.js",
                     filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                     filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                     filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                     filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                     filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                     filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
                });
            });


            $(document).delegate("input[type=\"checkbox\"]","change", function() {
               $(document).find("input[type=\"checkbox\"]").not(this).prop("checked", false);
            });
            $(".question_sub_btn").on("click",function(){
                var flag = $(document).find("input[type=\"checkbox\"]:checked").length;
                if(flag > 0){

                }else{
                    alert("Please select a correct answer.");
                    return false;
                }
                
            });
    ', yii\web\View::POS_READY, 'dynamic-form_js');
?>
