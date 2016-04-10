<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel institution\models\CoursesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="inner_container">
            <div class="ac_point account_ac_point">
                <h3>Courses</h3>
                <a href="<?= Url::toRoute('courses/create'); ?>" class="add_batches">Add</a>               
            </div>

            <div class="points_history_table col-md-12">
                <div class="row">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'course_name',
                            
                            

                            [  
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{delete}',
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
                                    }
                                ],

                                'urlCreator' => function ($action, $model, $key, $index) {
                                    
                                        $url = Url::toRoute(['courses/'.$action,'id'=>$model->id]);
                                        return $url;
                                }

                            ],
                        ],
                    ]); ?>
                  
                </div>
            </div>


        </div>
    </div>
</div>

<div class="courses-index">


    

</div>
