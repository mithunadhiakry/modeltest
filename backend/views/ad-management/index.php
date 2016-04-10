<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ad Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-management-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ad Management', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ad_name',
            'ad_identifier',
            'ad_description:ntext',
            'status',
            // 'time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
