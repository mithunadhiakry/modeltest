<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserNotificationRelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Notification Rels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notification-rel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Notification Rel', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'notification_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
