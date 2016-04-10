<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Country;
use backend\models\Category;
use backend\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\QuestionsetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questionsets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionset-index">

   
    <?php Pjax::begin(['id' => 'questions']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            'question_set_id',
            'question_set_name',
            'exam_time', 
            [
                'format' => 'raw',
                'attribute' => 'country_id',
                'value' => function($data){
                    $x=$data->getCountryname($data->country_id);
                    return $x;
                },
                'filter' => Html::activeDropDownList($searchModel, 'country_id', ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select country']),
            ],
            [
                'format' => 'raw',
                'attribute' => 'category_id',
                'value' => function($data){
                    $x=$data->getParentcategoryname($data->category_id);
                    return $x;
                },
                'filter' => Html::activeDropDownList($searchModel, 'category_id', Category::getCountrySortList($searchModel->country_id),['class'=>'form-control','prompt' => 'Select Category']),
            ],
            [
                'format' => 'raw',
                'attribute' => 'sub_category_id',
                'value' => function($data){
                    $x=$data->getParentcategoryname($data->sub_category_id);
                    return $x;
                },
                'filter' => Html::activeDropDownList($searchModel, 'sub_category_id', Category::getSubCategorySortList($searchModel->category_id),['class'=>'form-control','prompt' => 'Select Sub Category']),
            ],
            [
                'format' => 'raw',
                'attribute' => 'subject_id',
                'value' => function($data){
                    $x=$data->getSubjectname($data->subject_id);
                    return $x;
                }
            ],


            [  
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add}',
                'buttons' => [
                    'add' => function ($url, $model) {
                        return Html::a('Assign',$url, [
                                    'title' => 'Assign',
                                    'class'=>'btn btn-primary btn-xs add_item_btn',          
                        ]);
                    },
                ],

                'urlCreator' => function ($action, $model, $key, $index) {
                    
                        $url = Url::toRoute(['questionset/assign_user','id'=>$model->id]);
                        return $url;
                }

            ],
        ],
        'export' => false
    ]); ?>
    <?php Pjax::end() ?>

</div>
