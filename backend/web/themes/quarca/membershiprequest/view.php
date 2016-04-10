<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Package;

$package_data = Package::find()
                ->where(['id' => $model->package_id])
                ->one();
/* @var $this yii\web\View */
/* @var $model frontend\models\Membershiprequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Membershiprequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="membershiprequest-view pane">

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

    <table class="table table-striped table-bordered detail-view">

        <tbody>

            <tr>
                <th>Invoice Id</th>
                <td><?= $model->invoice_id; ?></td>
            </tr>
            <tr>
                <th>Payment Type</th>
                <td><?= $model->payment_type; ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <?php
                        if($model->status == 1){
                            echo 'Paid';
                        }else{
                            echo 'Unpaid';
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Package Type</th>
                <td><?= $package_data->package_type; ?></td>
            </tr>

            <tr>
                <th>Price</th>
                <td><?= $package_data->price_bd; ?> Tk.</td>
            </tr>

            <tr>
                <th>Date</th>
                <td><?= $model->timestamp; ?></td>
            </tr>

        </tbody>

    </table>


</div>
