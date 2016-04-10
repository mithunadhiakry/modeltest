<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use backend\models\Countrycategoryrel;
use backend\models\Country;
use backend\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index pane">

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'countries']) ?>
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

                // 'id',
                 [
                    'format' => 'raw',
                    'attribute' => 'parent_id',
                    'value' => function($data){
                        $x=$data->getParentcategoryname($data->parent_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'parent_id', Category::getCountrySortList($searchModel->country_id),['class'=>'form-control','prompt' => 'Select Parent Category']),
                ],
                'category_name',
                [
                    'format' => 'raw',
                    'attribute' => 'country_id',
                    'value' => function($data){
                        $x=$data->getCountryname($data->country_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'country_id', ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name'),['class'=>'form-control','prompt' => 'Select country']),
                ],

                // [
                //     'format' => 'text',
                //     'attribute' => 'countryname',
                //     'value' => function($data){
                //         $x=$data->getCountryname($data->id);
                //         return $x;
                //     },
                //     'filter' => Html::activeDropDownList($searchModel, 'countryname', ArrayHelper::map(Countrycategoryrel::find()->joinWith('country')->asArray()->all(), 'country_id', 'country.name'),['class'=>'form-control','prompt' => 'Select country']),
                // ],

                // 'meta_key',
                // 'meta_description',
                // 'sort_order',
                // 'country_id',
                // 'created_at',
                // 'created_by',
                // 'updated_at',
                // 'updated_by',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    <?php Pjax::end() ?>

</div>
