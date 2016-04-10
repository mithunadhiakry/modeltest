<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\QuestionsetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questionsets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="inner_container">
            <div class="ac_point account_ac_point">
                <h3>Question Set</h3>
                <a href="<?= Url::toRoute('questionset/create'); ?>" class="add_batches">Add</a>               
            </div>

             <div class="points_history_table col-md-12">
                <div class="row">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            
                            ['class' => 'yii\grid\SerialColumn'],
                            'question_set_id',
                            'question_set_name',
                            'exam_time', 
                            // 'pasue',
                            // 'deduct_on_pause',
                            // 'country_id',
                            // 'category_id',
                            // 'sub_category_id',
                            // 'subject_id',
                            // 'status',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                        
                    ]); ?>

                </div>
            </div>

        </div>
    </div>
</div>

    