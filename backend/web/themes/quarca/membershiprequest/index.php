<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MembershiprequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Membershiprequests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membershiprequest-index pane">
    <p><?= Html::a('Paid', ['allpaid'], ['class' => 'btn btn-success']) ?>&nbsp;<?= Html::a('Unpaid', ['index'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            'invoice_id',
            'payment_type',
            // 'status',
            // 'timestamp',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
