<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use institution\models\Courses;
use institution\models\Batch;
use institution\models\Questionset; 


$this->title = 'Batches | Model Test';
$this->params['breadcrumbs'][] = $this->title;

$courses = Courses::get_all_course_list();
$batches = Batch::get_all_batch_list_for_sort();

?>
<div class="container">
    <div class="row">
        <div class="inner_container">
            <div class="ac_point account_ac_point">
                <h3>Batch</h3>
                <div class="view_option_container view_option_batch">
                    <form>
                        <div class="form-control">
                            <label>View batch</label>
                            <select id="select_batch">
                                <option value="0">All</option>
                                <?php
                                    if(!empty($batches)){
                                        foreach ($batches as $key => $value) {
                                ?>

                                    <option value="<?= $key; ?>"><?= $value; ?></option>

                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>


                <div class="view_option_container view_option_batch">
                    <form>
                        <div class="form-control">
                            <label>View course</label>
                            <select id="select_course">
                                <option value="0">All</option>
                                <?php
                                    if(!empty($courses)){
                                        foreach ($courses as $key => $value) {
                                ?>

                                    <option value="<?= $key; ?>"><?= $value; ?></option>

                                <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <a href="<?= Url::toRoute('batch/create'); ?>" class="add_batches">Add</a>               
            </div>

            <div class="points_history_table col-md-12">
                <div class="row">
                    <?php Pjax::begin(['id' => 'countries']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'batch_no',
                            [
                                'format' => 'raw',
                                'attribute' => 'course_id',
                                'value' => function($data){
                                    $x=$data->getCoursename($data->course_id);
                                    return $x;
                                }
                            ],
                            [
                                'format' => 'raw',
                                'options' => ['style' => 'width:150px;'],
                                'attribute' => 'student_amount',
                                'value' => function($data){
                                    $x=$data->getNumberofstudent($data->id);
                                    return $x;
                                }
                            ],

                            'course_start',
                            'course_end',
                            
                            [  
                                'class' => 'yii\grid\ActionColumn',
                                'options' => ['style' => 'width:300px;'],
                                'template' => '{update}{delete}{assign_exam}{reports}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::a('Edit',$url, [
                                                    'title' => 'Edit',
                                                    'class'=>'btn btn-primary btn-xs add_item_btn',          
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('Remove',$url, [
                                                    'title' => 'Remove',
                                                    'class'=>'btn btn-primary btn-xs remove_item_btn',
                                                    'data-method' => 'post',
                                                    'data-confirm'=>'Are you sure you want to delete this item?',
                                                    'data-pjax' => '0',          
                                        ]);
                                    },
                                    'assign_exam' => function ($url, $model) {
                                        return Html::a('Assign Exam',$url, [
                                                    'title' => 'Assign Exam',
                                                    'class'=>'btn btn-primary btn-xs remove_item_btn model_open', 
                                                    'batch_id' => $model->id,
                                                    'course_id' => $model->course_id         
                                        ]);
                                    },
                                    'reports' => function ($url, $model) {
                                        return Html::a('Reports',$url, [
                                                    'title' => 'Reports',
                                                    'class'=>'btn btn-primary btn-xs remove_item_btn report_btn', 
                                                    'batch_id' => $model->id,
                                                    'course_id' => $model->course_id,
                                                    'data-pjax' => '0',       
                                        ]);
                                    }
                                ],

                                'urlCreator' => function ($action, $model, $key, $index) {
                                    
                                        $url = Url::toRoute(['batch/'.$action,'id'=>$model->id]);
                                        return $url;
                                }

                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end() ?>

                    <!-- Modal -->
                    <div id="open_assign_exam_model" class="modal fade bs-example-modal-lg-p" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content assign_student_box">
                            <div class="css_loader_container_wrap">
                                <div class="css_loader_container">
                                    <div class="cssload-loader"></div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div id="report_modal" class="modal fade bs-example-modal-lg-p" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabels">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
                                <h4 id="myModalLabelx" class="modal-title">Report</h4>
                            </div>
                            <div class="share_my_friend_container">
                                <?php
                                    $Questionset = new Questionset();

                                    $form = ActiveForm::begin(
                                        [      
                                            'action' => Url::base().'/batch/get_assigned_students',                  
                                            'options' => [
                                                'class' => 'get_reports'
                                            ]
                                        ]
                                    );
                                ?>
                                 
                                    <div class="share_my_friend_box report_box">
                                        <label>Model Test</label>
                                        <?php
                                            echo $form->field($Questionset, 'question_set_name')->widget(Select2::classname(), [
                                                'data' => Questionset::get_all_question_list(),
                                                'options' => ['placeholder' => 'Select a question set ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                                'pluginEvents' => [
                                                    'change' => 'function() { 
                                                        $(this).closest("form").submit();
                                                    }'
                                                ],
                                            ])->label(false);    
                                        ?>
                                        
                                        <!-- <input type="hidden" name="assign_item" value="">
                                        <input type="hidden" name="exam_type"> -->
                                        <input type="hidden" name="batch_id" id="report_batch_id" value="">
                                        <input type="hidden" name="course_id" id="report_course_id" value="">


                                    </div>
                                 <?php ActiveForm::end(); ?>
                                 <div class="result"></div>
                            </div>

                            <div class="view_lists_of_all_assigned_user">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th>Student Id</th>
                                        <th>Model Test</th>
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </table>
                            </div>

                        </div>
                      </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<?php
    $this->registerJs("
        $(document).delegate('.report_btn','click',function(){

            $('#report_batch_id').val($(this).attr('batch_id'));
            $('#report_course_id').val($(this).attr('course_id'));

            $('#report_modal').modal('show');
            
            return false;
        });

        $('body').on('beforeSubmit', 'form.get_reports', function () {
             var form = $(this);

             $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                dataType : 'json',
                beforeSend: function(){
                    
                },
                success: function (data) {
                    console.log(data.message);
                    $('#report_modal .view_lists_of_all_assigned_user').html(data.message);
                }
             });
             return false;
        });
    ", yii\web\View::POS_READY, "report_batch");

    $this->registerJs("
        $('.model_open').on('click',function(){

            var batch_id = $(this).attr('batch_id');            
            var course_id = $(this).attr('course_id');

            $('#open_assign_exam_model').modal('show');
            
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('batch/assign_exam')."',
                data: {batch_id:batch_id,course_id:course_id},
                beforeSend : function( request ){
                    $('#open_assign_exam_model .css_loader_container_wrap').fadeIn();
                },
                success : function( data )
                    {   
                        $('#open_assign_exam_model .css_loader_container_wrap').fadeOut();
                        $('#open_assign_exam_model .assign_student_box').html(data.message);
                    }
            });
            return false;
        });
    ", yii\web\View::POS_READY, "assign_exam_for_batch");


    $this->registerJs("

    
        $('#select_course').on('change',function(){
            
            var id = $(this).val();
            var type = 'course';
            
            set_time(id,type);

            return false;
        });

        $('#select_batch').on('change',function(){
            
            var id = $(this).val();
            var type = 'batch';
            
            set_time(id,type);

            return false;
        });

        function set_time(id,type){
            $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : '".Url::toRoute('batch/set_session')."',
                    data: {id:id,type:type},
                    beforeSend : function( request ){
                        
                    },
                    success : function( data )
                    {   
                        $.pjax.reload({container:'#countries'});
                        //$('#w0').yiiGridView('applyFilter');
                    }
                });

            return false;
        }



    ", yii\web\View::POS_READY, "model_test");

?>