<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Membershiprequest;

$this->title = 'User Panel | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="membershiprequest-index table-responsive pane">

	<div class="user_panel_custom_tab">
		<a href="<?= Url::toRoute(['membershiprequest/all_user']);?>" class="active">All Users</a>
		<a href="<?= Url::toRoute(['membershiprequest/new_member']) ?>">New Member Approval</a>
		<a href="<?= Url::toRoute(['membershiprequest/pending_payment'])?>">Pending Payments</a>
	</div>

	<div class="user_panel_all_users">

		<?php Pjax::begin(['id' => 'all_users','enablePushState' => false]) ?>

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

	            [
                    'attribute' => 'email',
                    'label' => 'Email',
                    'format' => 'raw',
                    'value' => function($model, $index, $dataColumn) {
                        return '<a href="'.Url::toRoute('user/view?id='.$model->id).'">'.$model->email.'</a>';
                    }
                ],
	            'name',
	            'user_type',
	            [
                    'attribute' => 'created_at',
                    'label' => 'Registratio Date & Time',
                    'value' => function($model, $index, $dataColumn) {
                        return date_format(date_create($model->created_at), 'd-m-Y h:m A');
                    }
                ],
            [
                'attribute' => 'status',
                'label' => 'Membership Status',
                'format' => 'raw',
                'value' => function($model, $index, $dataColumn) {
                    return $model->memreqstatus;
                },
                'filter' => Select2::widget([
                    'name' => 'UserSearch[memreqstatus]',
                    'value' => $searchModel->memreqstatus,
                    'data' => array('PAID' => 'PAID','FREE' => 'FREE'),
                    'options' => ['multiple' => false, 'placeholder' => 'Select ...','style'=>'width:150px;']
                ])
            ],
            [
                'attribute' => 'membershipexpired',
                'label' => 'Membership Expired',
                'format' => 'raw',
                'value' => function($model, $index, $dataColumn) {
                    return $model->getMemebershipexperied();
                }
            ],
            

	        ],
	    ]); ?>

	</div>
	<?php Pjax::end() ?>

</div>

<?php
    
    $this->registerJs("

        $( document ).ready(function() {
            $('.sidebar-switch').click();            
        });

    ", yii\web\View::POS_READY, "user_panel_open_in_dashboard");

?>