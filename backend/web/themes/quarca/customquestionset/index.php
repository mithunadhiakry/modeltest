<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\QuestionsetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Custom Question sets';
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
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            'question_set_id',
            'question_set_name',
            'exam_time', 
            // 'pasue',
            // 'deduct_on_pause',
            // 'country_id',
            // 'category_id',
            // 'sub_category_id',
            // 'subject_id',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'export' => false
    ]); ?>

</div>
