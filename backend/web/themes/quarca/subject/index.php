<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

use backend\models\Country;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subjects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-index pane">

    <p>
        <?= Html::a('Create Subject', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(['id' => 'subjects']) ?>
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

                'subject_name',
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
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', Category::getCountrySortList($searchModel->country_id),['class'=>'form-control','prompt' => 'Select Parent Category']),
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'sub_category_id',
                    'value' => function($data){
                        $x=$data->getParentcategoryname($data->sub_category_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'sub_category_id', Category::getSubCategorySortList($searchModel->category_id),['class'=>'form-control','prompt' => 'Select Parent Category']),
                ],
                
                
                // 'meta_key',
                // 'meta_description',
                // 'category_id',
                // 'sort_order',
                // 'created_at',
                // 'created_by',
                // 'updated_at',
                // 'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end() ?>

</div>
