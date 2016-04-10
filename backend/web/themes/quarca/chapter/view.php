<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Subject;

/* @var $this yii\web\View */
/* @var $model backend\models\Chapter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chapters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12">
    <div class="row">
        <div class="chapter-view pane">
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
                    'chaper_name',
                    'chapter_status',
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
                        <td>Subject</td>
                        <td>
                            <?php

                                foreach($subject_chapter_model_q as $subject_chapter_model){
                                    $subject_data = Subject::find()->where(['id'=>$subject_chapter_model->subject_id])->one();
                                    echo $subject_data->subject_name . ' , ';
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>