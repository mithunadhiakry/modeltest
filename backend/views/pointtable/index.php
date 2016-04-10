<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PointTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Point Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-table-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Point Table', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'identifier',
            'points',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
