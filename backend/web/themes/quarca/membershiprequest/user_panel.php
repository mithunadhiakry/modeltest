<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Membershiprequest;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MembershiprequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Panel | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membershiprequest-index table-responsive pane">


    <div class="user_panel_custom_tab">
        <a href="<?= Url::toRoute(['membershiprequest/all_user']);?>" >All Users</a>
        <a href="<?= Url::toRoute(['membershiprequest/new_member']) ?>">New Member Approval</a>
        <a href="<?= Url::toRoute(['membershiprequest/pending_payment'])?>" class="active">Pending Payments</a>
    </div>
    
    <div class="user_panel_all_users">   
        <?php Pjax::begin(['id' => 'membership_paid_due']) ?>

        <?php $form = ActiveForm::begin([
                'id' => 'membershiprequest-paymentstatus',
                'method'=>'GET'
            ]); ?>

            <div class="col-md-12">
                <div class="row">

                     <label class="control-label" for="userfront-country">Check Payment Status</label>

                     <?php
                        echo $form->field($payment_status_modal, 'status')->widget(Select2::classname(), [
                            'data' => Membershiprequest::get_all_payment_list(),
                            'options' => ['placeholder' => 'Select payment status ...','multiple'=>false],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'pluginEvents' =>[
                                "change" => "function() { 
                                    $('#membershiprequest-paymentstatus').submit();
                                 }",
                            ]
                        ])->label(false);    
                    ?>


                </div>
            </div>

        <?php ActiveForm::end(); ?>

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
                        'attribute' => 'user_profile',
                        'label' => 'User ID(Email)',
                        'format' => 'raw',
                        'value' => function($model, $index, $dataColumn) {
                            return $model->getUserdata();
                            //return Html::a($model->invoice_id,'invoice?id='.$model->invoice_id, ['target'=>'_blank']);
                        }
                    ],

                    [
                        'attribute' => 'invoice_id',
                        'label' => 'Invoice Number',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::a($model->invoice_id,'invoice?id='.$model->invoice_id, ['target'=>'_blank']);
                        }
                    ],
                    [
                        'attribute' => 'points_pack',
                        'label' => 'Points Pack',
                        'value' => function($model, $index, $dataColumn) {
                            return $model->getPackagedata();
                        }
                    ],
                    'payment_type',
                    'discounts_code',
                     [
                        'attribute' => 'discounts_amount',
                        'label' => 'Discounts Amount',
                        'value' => function($model, $index, $dataColumn) {
                            return $model->getAmountofdiscountdata();
                        }
                    ],
                     [
                        'attribute' => 'amounts_of_payment',
                        'label' => 'Amount of Payment',
                        'value' => function($model, $index, $dataColumn) {
                            return $model->getAmountofpaymentdata();
                        }
                    ],
                    
                     [
                        'attribute' => 'timestamp',
                        'label' => 'Buy Date & time',
                        'value' => function($model, $index, $dataColumn) {
                            return date_format(date_create($model->timestamp), 'd-m-Y');
                        }
                    ],
                    [
                        'attribute' => 'expired_date',
                        'label' => 'Expired',
                        'value' => function($model, $index, $dataColumn) {

                            $next_date = date_format(date_create($model->timestamp), 'd-m-Y');

                            return date('d-m-Y', strtotime('+1 month', strtotime($next_date)));
                           
                        }
                    ],             
                    [  
                        
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{confirm}',
                        'buttons' => [

                            'confirm' => function ($url, $model) {

                                if($model->status == 0){

                                    return Html::a('Due',$url, [
                                            'title' => 'Due',
                                            'class'=>'btn btn-primary btn-xs due_payment',
                                            'data-type' => 'delete' ,
                                            'data-pjax' => 0,
                                            'data' => [
                                                'confirm' => 'Are you sure you want to receive this purchase?',
                                                'method' => 'post',
                                            ],                                
                                    ]);

                                }else{
                                    return '<span class="paid_button">Paid</span>';
                                }
                                
                            },
                        ],

                        'urlCreator' => function ($action, $model, $key, $index) {
                            
                                $url = Url::toRoute(['membershiprequest/confirm_payment','id'=>$model->id]);
                                return $url;
                        }

                    ],
                    [  
                        
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{confirm}',
                        'buttons' => [

                            'confirm' => function ($url, $model) {

                                return Html::a('<span class="glyphicon glyphicon-trash"><span>',$url, [
                                            'title' => 'Due',
                                            'class'=>'btn btn-primary btn-xs due_payment',
                                            'data-type' => 'delete' ,
                                            'data-pjax' => 0,
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this purchase?',
                                                'method' => 'post',
                                            ],                                
                                    ]);
                                
                            },
                        ],

                        'urlCreator' => function ($action, $model, $key, $index) {
                            
                                $url = Url::toRoute(['membershiprequest/deletemembership','id'=>$model->id]);
                                return $url;
                        }

                    ],



                ],
            ]); ?>

        <?php Pjax::end() ?>
    </div>
</div>

<?php
    
    $this->registerJs("

        $( document ).ready(function() {
            $('.sidebar-switch').click();            
        });

    ", yii\web\View::POS_READY, "user_panel_open_in_dashboard");

?>