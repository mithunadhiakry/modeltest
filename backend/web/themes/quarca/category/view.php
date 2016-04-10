<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Country;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
    <div class="row">
        <div class="category-view pane">

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

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'category_name',
                    'category_status',
                    'sort_order',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                ],
            ]) ?>
                

            <table class="table table-striped table-bordered detail-view">
                <tbody>
                    <tr>
                        <th>Country</th>
                        <td>
                            <?php

                                foreach($country_category_model_q as $country_category_model){
                                    $country_data = Country::find()->where(['id'=>$country_category_model->country_id])->one();
                                    echo $country_data->name;
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>