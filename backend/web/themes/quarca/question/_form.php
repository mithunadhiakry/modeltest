<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use \kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use kartik\widgets\DepDrop;

use backend\models\Country;
use backend\models\Subject;
use backend\models\Category;
use backend\models\Chapter;

$model->country_id = $model->country->country_id;
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>


<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="question-form">

                        <?php $form = ActiveForm::begin(); ?>

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
                                <label class="control-label" for="userfront-country">Subject Name</label>
                                
                                    <?php
                                        echo $form->field($model, 'subject_id')->widget(DepDrop::classname(), [
                                            'data'=> Subject::get_all_subject_list(),
                                            'options' => ['placeholder' => 'Select a subject ...'],
                                            'type' => DepDrop::TYPE_SELECT2,
                                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                            'pluginOptions'=>[
                                                'depends'=>['question-category_id'],
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

                        

                        


                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <div class="col-md-12">
                            <?php

                                Pjax::begin(['id' => 'countries']);
                                  $form = ActiveForm::begin(['id' => 'answer_list_form']);
                                  


                                  echo TabularForm::widget([
                                      'dataProvider'=>$dataProvider,
                                      'form'=>$form,
                                      'attributes'=>$model_q->formAttribs,
                                      'gridSettings'=>[
                                          'floatHeader'=>true,
                                          'panel'=>[
                                              'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
                                              'type' => GridView::TYPE_PRIMARY,
                                              'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success add_ans_btn']) . ' ' . 
                                                      //Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
                                                      Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary tabular_save_btn'])
                                          ]
                                      ],
                                      'checkboxColumn'=>false,
                                      'actionColumn'=> [
                                            'class' => '\kartik\grid\ActionColumn',
                                            'template' => '{update} {delete}',
                                            'width' => '60px',
                                            'buttons' => [
                                                'update' => function ($url, $model) {
                                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                                'title' => Yii::t('app', 'Info'),
                                                    ]);
                                                },
                                                'delete' => function ($url, $model) {
                                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                                'title' => Yii::t('app', 'Info'),
                                                                'class' => 'delete_ans_btn'
                                                    ]);
                                                }
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                                if ($action === 'update') {
                                                    $url = Url::toRoute(['update','id'=>$key]); // your own url generation logic
                                                    return $url;
                                                }
                                                if ($action === 'delete') {
                                                    $url = Url::toRoute(['delete_answer','id'=>$key]); // your own url generation logic
                                                    return $url;
                                                }
                                            }

                                        ]
                                  ]);
                                  ActiveForm::end();

                                Pjax::end();
                                        
                              ?>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


<div class="modal fade" id="add_answer_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Answer</h4>
      </div>
      <div class="modal-body">
            <div class="col-md-12">
                <?php $form1 = ActiveForm::begin([
                        'id' => 'add_answer_form',
                        'enableAjaxValidation' => false,
                        'enableClientValidation' =>  true,
                        'action' =>'save_answer'
                    ]); ?>
                    
                    <div class="col-md-10">
                        <?php
                            $answer_model->question_id = $model->id;
                            echo $form->field($answer_model, 'question_id')->hiddenInput()->label(false); 
                        ?>

                        <?= $form1->field($answer_model,'answer')->textarea(['rows' => '2']) ?>
                    </div>
                    <div class="col-md-2">
                        <div class="col-md-12">
                            <?= $form1->field($answer_model, 'is_correct')->checkbox(); ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form1->field($answer_model, 'sort_order')->textInput(); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
      </div>

    </div>
  </div>
</div>

<?php
    
    $this->registerJs("
                    $(document).delegate('.delete_ans_btn', 'click', function() { 
                        var url = $(this).attr('href');
                        
                        BootstrapDialog.confirm({
                                title: 'WARNING',
                                message: 'Are you sure you want to delete it?',
                                type: BootstrapDialog.TYPE_WARNING,
                                closable: false,
                                draggable: true,
                                btnCancelLabel: 'Do not delete it!',
                                btnOKLabel: 'Delete it!',
                                callback: function(result) {
                                    if(result) {
                                        window.location = url;
                                    }else {
                                        return false;
                                    }
                                }
                        });

                        return false;
                        
                    });
    ", yii\web\View::POS_END, 'delete_ans');

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#add_answer_form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            //$('#countries').html(dt.specification_list);
                                            location.reload();
                                            //$('#myModal_create_cat').modal('hide');

                                            //alertify.log('Post has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })

            );

            $(document).delegate('.add_ans_btn','click',function(){
                $('#add_answer_modal').modal('show');
                return false;
            });

    ", yii\web\View::POS_READY, 'add_new_ans');

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#countries #answer_list_form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){

                                            alertify.log(dt.files, 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );


    ", yii\web\View::POS_END, 'update_answers');

    

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

            CKEDITOR.replace( "answerlist-answer", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });


    ', yii\web\View::POS_READY, 'ck_editor_post');

?>
