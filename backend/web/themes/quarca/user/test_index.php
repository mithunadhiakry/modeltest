<?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\grid\GridView;
    use app\models\User;
?>

<?php Pjax::begin(['id' => 'membership_paid_dues']) ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'invoice_id',
            
            [
                'attribute' => 'test',
                'label' => 'test',
                'value' => function($model, $index, $dataColumn) {
                    return $model->getFirstName();
                }
            ],
            
        ],
    ]); ?>

<?php Pjax::end() ?>