<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AdManagement */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ad Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-management-view">

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'ad_name',
            // 'ad_identifier',
            'ad_description:ntext',
            // 'status',
            // 'time',
        ],
    ]) ?>

</div>
