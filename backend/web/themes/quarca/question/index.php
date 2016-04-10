<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;
use backend\models\Country;
use backend\models\Category;
use backend\models\Chapter;
use backend\models\Subject;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-index pane">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Question', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php Pjax::begin(['id' => 'questions']) ?>
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
                /*'id',*/
                [
                    'attribute' => 'details',
                    'format' => 'html',
                    'value' => function($data) { 
                        $charset = 'UTF-8';
                        $length = 70;
                        $string = strip_tags($data->details);
                        if(mb_strlen($string, $charset) > $length) {
                            $string = mb_substr($string, 0, $length - 3, $charset) . ' ...';
                        }
                        return $string; 
                    },
                ],
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
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', Subject::getSubjectSortList($searchModel->sub_category_id),['class'=>'form-control','prompt' => 'Select Subject']),
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'chapter_id',
                    'value' => function($data){
                        $x=$data->getChaptername($data->chapter_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'chapter_id', Chapter::getChapterSortList($searchModel->subject_id),['class'=>'form-control','prompt' => 'Select Chapter']),
                ],
                // 'status',
                // 'created_at',
                // 'updated_at',
                // 'created_by',
                // 'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
            'rowOptions'=>function ($model, $key, $index, $grid){

                $class=$index%2?'odd':'even';

                return array('key'=>$key,'index'=>$index,'class'=>$class);

            },

        ]); ?>
    <?php Pjax::end() ?>

</div>
