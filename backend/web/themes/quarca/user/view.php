<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
    <div class="row">
        <div class="user-view pane" style="width: 100%;float: left;">


            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <div class="col-md-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'email:email',
                        'username',
                        'phone',
                        'address:html',
                        [                      // the owner name of the model
                            'label' => 'Status',
                            'value' => ($model->status==1)?'Active':'Inactive',
                        ],
                    ],
                ]) ?>
            </div>

            <?php
                if($model->user_type == 'student'){
            ?>
                    <!-- <div class="col-md-4">
                        <h3 style="margin-top:10px; margin-bottom:0;">Free Point</h3>
                        <p><?= $model->free_point; ?></p>

                        <h3 style="margin-top:10px; margin-bottom:0;">Purchased Point</h3>
                        <p><?= $model->purchased_point; ?></p>
                    
                        <h3 style="margin-top:10px; margin-bottom:0;">Expiry Date</h3>
                        <p><?= $model->expire_date; ?></p>
                    </div> -->
            <?php
                }
            ?>

            <div class="col-md-12">
                 <table class="table table-striped table-bordered detail-view">
                    <tbody>
                        <tr>
                            <th>Date Of Birth</th>
                            <td><?=  date_format(date_create($model->details->date_of_birth), 'dS F Y')?></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td><?= $model->details->gender?></td>
                        </tr>
                        <tr>
                            <th>Education Level (last)</th>
                            <td><?= $model->details->education?></td>
                        </tr>
                        <tr>
                            <th>Education Institution</th>
                            <td><?= $model->details->institution_name?></td>
                        </tr>
                        <tr>
                            <th>Employee Status</th>
                            <td><?= $model->details->employee_status?></td>
                        </tr>
                        <tr>
                            <th>Organization</th>
                            <td><?= $model->details->employee_organization?></td>
                        </tr>
                        <tr>
                            <th>How do you know about model-test.com?</th>
                            <td><?= $model->details->how_do_you_know_about_modeltest?></td>
                        </tr>
                        <tr>
                            <th>What is your main expectation from model-test.com?</th>
                            <td><?= $model->details->your_expectation?></td>
                        </tr>
                         <tr>
                            <th>Will you recommend model-test.com to others, if you find it helpful?</th>
                            <td><?= $model->details->recommended_other?></td>
                        </tr>


                    </tbody>
                </table>
            </div>
           
          

        </div>
    </div>
</div>