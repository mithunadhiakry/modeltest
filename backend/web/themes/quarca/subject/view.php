<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Category;

/* @var $this yii\web\View */
/* @var $model backend\models\Subject */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
    <div class="row">
        <div class="subject-view pane">
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
                    'subject_name',
                    'subject_status',
                    'exam_time',
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
                        <td>Category</td>
                        <td>
                            <?php

                                foreach($category_subject_model_q as $category_subject_model){
                                    $category_data = Category::find()->where(['id'=>$category_subject_model->category_id])->one();
                                    echo $category_data->category_name . ' , ';
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>