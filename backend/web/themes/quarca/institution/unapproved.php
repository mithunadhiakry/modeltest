<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unapproved Institutions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-index pane">

    <p>
        <?= Html::a('Create Institution', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'email:email',
            'phone',
            'address:ntext',
            // 'image',
            // 'password',
            // 'country',
            // 'status',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {approve}',
                    'buttons' => [
                        
                        'approve' => function ($url, $model) {
                            return Html::a('Approve', $url, [
                                        'title' => 'Approve', 
                                        'class' => 'approve'                                 
                            ]);
                        },
                    ],

                ],
        ],
    ]); ?>

</div>

<?php
    $this->registerJs("
                    $(document).delegate('.approve', 'click', function() { 
                        var url = $(this).attr('href');
                        
                        BootstrapDialog.confirm({
                                title: 'WARNING',
                                message: 'Are you sure you want to approve it?',
                                type: BootstrapDialog.TYPE_WARNING,
                                closable: false,
                                draggable: true,
                                btnCancelLabel: 'Do not approve it!',
                                btnOKLabel: 'Approve it!',
                                callback: function(result) {
                                    if(result) {
                                        window.location = url;
                                    }else {
                                        return false;
                                    }
                                }
                        });

                        return false;
                        
                    });
    ", yii\web\View::POS_END, 'approve');
?>