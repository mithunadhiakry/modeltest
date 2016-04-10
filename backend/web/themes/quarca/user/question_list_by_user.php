<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\User;
use backend\models\Subject;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

use yii\widgets\Pjax;

use backend\models\Country;
use backend\models\Category;
use backend\models\Chapter;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions List By User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="question-index pane">

    <?php $form = ActiveForm::begin([
        'id' => 'user-form',
        'method'=>'GET'
    ]); ?>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="userfront-country">User Name</label>
                    
                        <?php
                            echo $form->field($model, 'created_by')->widget(Select2::classname(), [
                                'data' => User::get_all_adminuser_list(),
                                'options' => ['placeholder' => 'Select a user ...','multiple'=>false],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'pluginEvents' =>[
                                    "change" => "function() { 
                                        $('#user-form').submit();
                                     }",
                                ]
                            ])->label(false);    
                        ?>
                    
                </div>
            </div>

            <div class="col-md-6">

                <div class="col-md-6">
                    <label style="width:100%;">From</label>
                    <input type="text" name="from_date" id="from_date" value="<?php if(isset($_GET['from_date'])){echo $_GET['from_date'];} ?>" />
                </div>

                <div class="col-md-6">
                    <label style="width:100%;">To</label>
                    <input type="text" name="to_date" id="to_date" value="<?php if(isset($_GET['to_date'])){echo $_GET['to_date'];} ?>" />
                </div>

                <?php
                    $this->registerJs('

                        $("#from_date").datepicker({
                             format: "yyyy-mm-dd",
                        });

                        $("#to_date").datepicker({
                             format: "yyyy-mm-dd",
                        });
                        

                        $("#from_date").change(function(){

                            var from_date = $("#from_date").val();
                            var to_date = $("#to_date").val();

                            if(from_date && to_date){
                                $("#user-form").submit();
                            }
                        });

                      $("#to_date").change(function(){

                            var from_date = $("#from_date").val();
                            var to_date = $("#to_date").val();

                            if(from_date && to_date){
                                $("#user-form").submit();
                            }
                        });


                    ', yii\web\View::POS_READY, 'date_range_picker');

                ?>
               

            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['id' => 'question-list']) ?>
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

            //'id',
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

            [  
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Actions',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Yii::t('app', 'View'),
                                    'class'=>'btn',                                  
                        ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url =Url::toRoute(['question/view', 'id'=>$model->id]);
                        return $url;
                    }
                }

            ],
        ],
    ]); ?>

    <?php Pjax::end() ?>

</div>
