<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\QuestionsetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questionsets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionset-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Questionset', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
                'options'=>['class'=>'pagination'],   // set clas name used in ui list of pagination
                'prevPageLabel' => 'Previous',   // Set the label for the "previous" page button
                'nextPageLabel' => 'Next',   // Set the label for the "next" page button
                'firstPageLabel'=>'First',   // Set the label for the "first" page button
                'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                
                ],
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            'question_set_id',
            'question_set_name',
            'alternate_name', 
            [
                        'attribute' => 'created_by',
                        'label' => 'Created by',
                        'value' => function($model, $index, $dataColumn) {
                            return $model->getUserdata();
                        }
            ],
           
            [

                'attribute'=>'status',
                'label'=>'Status',
                'contentOptions' =>function ($model, $key, $index, $column){
                        return ['class' => 'status'];
                },

                'content'=>function($data){

                    return $data->status==1?'Active':'Inactive';

                }

            ],
            // 'pasue',
            // 'deduct_on_pause',
            // 'country_id',
            // 'category_id',
            // 'sub_category_id',
            // 'subject_id',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'export' => false
    ]); ?>

</div>
