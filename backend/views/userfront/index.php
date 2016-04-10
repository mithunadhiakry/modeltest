<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserFrontSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Fronts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-front-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Front', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'password',
            'email:email',
            'phone',
            // 'address:ntext',
            // 'designation',
            // 'gender',
            // 'image',
            // 'date_of_birth',
            // 'education:ntext',
            // 'employee_status',
            // 'country',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
