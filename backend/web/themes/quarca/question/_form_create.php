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

use backend\models\Country;
use backend\models\Subject;
use backend\models\Category;
use backend\models\Chapter;

$total_ans = 0;

    $session = Yii::$app->session;

    $check_session_data = $session->get('country_id');
    if(isset($check_session_data) && $check_session_data != ''){
        $model->country_id = $session->get('country_id');
        $model->chapter_id = $session->get('chapter_id');
        $model->category_id = $session->get('category_id');
        $model->sub_category_id = $session->get('sub_category_id');
        $model->subject_id = $session->get('subject_id');
    }
     
    

?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="question-form">

                        <?php $form = ActiveForm::begin(['id'=>'question-form']); ?>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Country Name</label>
                                
                                    <?php
                                        echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                                            'data' => Country::get_all_country_list(),
                                            'options' => ['placeholder' => 'Select a country ...','multiple'=>false],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label(false);    
                                    ?>
                                
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Category Name</label>
                                
                                    
                                    <?php
                                        echo $form->field($model, 'category_id')->widget(DepDrop::classname(), [
                                            'data'=> Category::get_all_category_list(),
                                            'options' => ['placeholder' => 'Select a category ...'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                            'pluginOptions'=>[
                                                'depends'=>['question-country_id'],
                                                'url' => Url::to(['/question/getchildcategories']),
                                                'loadingText' => 'Loading category ...',
                                            ]
                                        ])->label(false);   
                                    ?>
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Sub Category Name</label>
                                
                                    
                                    <?php
                                        echo $form->field($model, 'sub_category_id')->widget(DepDrop::classname(), [
                                            'data'=> Category::get_all_sub_category_list(),
                                            'options' => ['placeholder' => 'Select a category ...'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                            'pluginOptions'=>[
                                                'depends'=>['question-category_id'],
                                                'url' => Url::to(['/question/getsubcategories']),
                                                'loadingText' => 'Loading sub category ...',
                                            ]
                                        ])->label(false);   
                                    ?>
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Subject Name</label>
                                
                                    <?php
                                        echo $form->field($model, 'subject_id')->widget(DepDrop::classname(), [
                                            'data'=> Subject::get_all_subject_list(),
                                            'options' => ['placeholder' => 'Select a subject ...'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>false]],
                                            'pluginOptions'=>[
                                                'depends'=>['question-sub_category_id'],
                                                'url' => Url::to(['/question/getchildsubjects']),
                                                'loadingText' => 'Loading subjects ...',
                                            ]
                                        ])->label(false);
                                           
                                    ?>
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Chapter Name</label>
                                
                                    
                                    <?php
                                        echo $form->field($model, 'chapter_id')->widget(DepDrop::classname(), [
                                            'data'=> Chapter::get_all_chapter_list(),
                                            'options' => ['placeholder' => 'Select a chapter ...'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                            'pluginOptions'=>[
                                                'depends'=>['question-subject_id'],
                                                'url' => Url::to(['/question/getchildchapters']),
                                                'loadingText' => 'Loading chapter ...',
                                            ]
                                        ])->label(false);
                                           
                                    ?>
                                
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="userfront-country">Comments</label>
                                <?= $form->field($model, 'questions_of_year')->textInput(['maxlength' => 255])->label(false); ?>
                            </div>
                        </div>


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
                                <?php
                                    if(empty($model->details)){

                                        echo Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success question_sub_btn' : 'btn btn-primary question_sub_btn']) . ' ';
                                        echo Html::submitButton('Save & Next', ['class' => 'btn btn-success question_sub_btn', 'value'=>'save_next', 'name'=>'submit']);
                                    }else{

                                        echo Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success question_sub_btn' : 'btn btn-primary question_sub_btn']) . ' ';
                                        echo Html::submitButton('Update & edit another', ['class' => 'btn btn-success question_sub_btn', 'value'=>'update_edit_another', 'name'=>'submit']);
                                    }
                                ?>
                                
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
