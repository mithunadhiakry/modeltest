<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorysubjectrelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categorysubjectrels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorysubjectrel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Categorysubjectrel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'subject_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
