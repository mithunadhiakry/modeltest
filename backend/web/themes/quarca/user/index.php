<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index pane">

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-primary btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
                'options'=>['class'=>'pagination'],   // set clas name used in ui list of pagination
                'prevPageLabel' => 'Previous',   // Set the label for the "previous" page button
                'nextPageLabel' => 'Next',   // Set the label for the "next" page button
                'firstPageLabel'=>'First',   // Set the label for the "first" page button
                'lastPageLabel'=>'Last',    // Set the label for the "last" page button
                'nextPageCssClass'=>'next',    // Set CSS class for the "next" page button
                'prevPageCssClass'=>'prev',    // Set CSS class for the "previous" page button
                'firstPageCssClass'=>'first',    // Set CSS class for the "first" page button
                'lastPageCssClass'=>'last',    // Set CSS class for the "last" page button
                
                ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'email:email',
            'username',
            'user_type',
            //'password',
            // 'auth_key',
            // 'password_reset_token',
            // 'status',

            ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {unapprove}',
                    'buttons' => [
                        
                        'unapprove' => function ($url, $model) {
                            return Html::a('Unapprove', $url, [
                                        'title' => 'Unapprove', 
                                        'class' => 'unapprove'                                 
                            ]);
                        },
                    ],

                ],
        ],
    ]); ?>

</div>


<?php
    $this->registerJs("
                    $(document).delegate('.unapprove', 'click', function() { 
                        var url = $(this).attr('href');
                        
                        BootstrapDialog.confirm({
                                title: 'WARNING',
                                message: 'Are you sure you want to unapprove it?',
                                type: BootstrapDialog.TYPE_WARNING,
                                closable: false,
                                draggable: true,
                                btnCancelLabel: 'Do not unapprove it!',
                                btnOKLabel: 'Unapprove it!',
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
    ", yii\web\View::POS_END, 'unapprove');
?>