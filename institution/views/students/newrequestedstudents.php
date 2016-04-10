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

$this->title = 'New requested students | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="inner_container">

        	<div class="ac_point account_ac_point">
                <h3>New Requested Students</h3>

            </div>

             <div class="points_history_table col-md-12">
                <div class="row">
                    <?php Pjax::begin(['id' => 'countries']) ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'email',

                             [

						            'class' => 'yii\grid\ActionColumn',

						            'header'=>'',

						            'headerOptions' => ['width' => '80'],

						            'template' => '{studentconfirm}{mmmm}',

                                    'buttons' => [

                                        'studentconfirm' => function ($url,$model) {

                                           

                                            return Html::a('<span class="glyphicon glyphicon-ok"></span>',$url, [
                                                    'title' => '',
                                                    'class'=>'',
                                                    'data-type' => 'delete' ,
                                                    'data-pjax' => 0,
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to confirm this student?',
                                                        'method' => 'post',
                                                    ],                                
                                            ]);

                                        },

                                        'link' => function ($url,$model,$key) {

                                                return Html::a('Action', $url);

                                        },

                                    ],
                        		],
                           
                           
                            // 'created_at',
                            // 'created_by',
                            // 'updated_at',
                            // 'updated_by',

                            
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