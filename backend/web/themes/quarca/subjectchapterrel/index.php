<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SubjectchapterrelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subjectchapterrels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjectchapterrel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Subjectchapterrel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject_id',
            'chapter_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
