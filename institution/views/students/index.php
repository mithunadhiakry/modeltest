<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use institution\models\Courses;
use institution\models\Batch;
use institution\models\Students;

$courses = Courses::get_all_course_list();
$batches = Students::get_all_batch_list_for_sort();
/* @var $this yii\web\View */
/* @var $searchModel institution\models\StudentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="inner_container">

            <div class="ac_point account_ac_point">
                <h3>Students</h3>


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
                <a href="<?= Url::toRoute('students/create'); ?>" class="add_batches">Add</a>               
            </div>

            <div class="points_history_table col-md-12">
                <div class="row">
                    <?php Pjax::begin(['id' => 'countries']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'format' => 'raw',
                                'attribute' => 'student_email',
                                'value' => function($data){
                                    $x=$data->getStudentemail($data->student_email);
                                    return $x;
                                }
                            ],
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
                                'attribute' => 'batch_no',
                                'value' => function($data){
                                    $x=$data->getBatchname($data->batch_no);
                                    return $x;
                                }
                            ],
                            [
                                'format' => 'raw',
                                'attribute' => 'course_start',
                                'value' => function($data){
                                    $x=$data->getCourseStart($data->batch_no);
                                    return $x;
                                }
                            ],

                            [
                                'format' => 'raw',
                                'attribute' => 'course_end',
                                'value' => function($data){
                                    $x=$data->getCourseEnd($data->batch_no);
                                    return $x;
                                }
                            ],
                           
                            // 'created_at',
                            // 'created_by',
                            // 'updated_at',
                            // 'updated_by',

                            [  
                                'class' => 'yii\grid\ActionColumn',
                                'options' => ['style' => 'width:250px;'],
                                'template' => '{update}{delete}{assign_exam}',
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
                                                    'title' => 'Edit',
                                                    'class'=>"btn btn-primary btn-xs remove_item_btn model_open",
                                                    'batch_id' => $model->batch_no,
                                                    'student_id' => $model->student_email,
                                                    'course_id' => $model->course_id
                                        ]);
                                    }
                                ],

                                'urlCreator' => function ($action, $model, $key, $index) {
                                    
                                        $url = Url::toRoute(['students/'.$action,'id'=>$model->id]);
                                        return $url;
                                }

                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end() ?>
                    
                    <!-- Modal -->

                    <div id="open_assign_exam_model" class="modal fade bs-example-modal-lg-p" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="css_loader_container_wrap">
                                <div class="css_loader_container">
                                    <div class="cssload-loader"></div>
                                </div>
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
        $('.model_open').on('click',function(){

            var batch_id = $(this).attr('batch_id');
            var student_id = $(this).attr('student_id');
            var course_id = $(this).attr('course_id');

            $('#open_assign_exam_model').modal('show');
            
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('students/assign_exam')."',
                data: {batch_id:batch_id,student_id:student_id,course_id:course_id},
                beforeSend : function( request ){
                    $('#open_assign_exam_model .css_loader_container_wrap').fadeIn();
                },
                success : function( data )
                    {   
                        $('#open_assign_exam_model .css_loader_container_wrap').fadeOut();
                        $('.modal-content').html(data.message);
                    }
            });
            return false;
        });
    ", yii\web\View::POS_READY, "assign_exam");

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
                    url : '".Url::toRoute('students/set_session')."',
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