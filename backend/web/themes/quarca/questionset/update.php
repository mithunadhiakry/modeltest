<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

use backend\models\AnswerList;
use backend\models\Subject;
use backend\models\Chapter;
use backend\models\Questionset;

/* @var $this yii\web\View */
/* @var $model frontend\models\Questionset */

$this->title = 'Update Questionset: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questionsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';


?>
<div class="questionset-update">


    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

    <?php
    	\yii\widgets\Pjax::begin(
		    [
		        'enablePushState'=>FALSE,
		        'id' => 'questions_added'
		    ]
		);
    ?>
    <div class="questions_grid2">
        <?= GridView::widget([
            'dataProvider' => $dataProvider1,
            'filterModel' => $searchModel1,
            'columns' => [
	            [
	                'class' => 'kartik\grid\ExpandRowColumn',
	                'value' => function($model, $key, $index, $column){
	                    return GridView::ROW_COLLAPSED;
	                },
	                'detail' => function($model, $key, $index, $column){
	                	$answer_list = AnswerList::find()->where(['question_id'=>$model->id])->all();
	                    return Yii::$app->controller->renderPartial('_question_view',[
	                    					'model'=>$model,
	                    					'answer_list' => $answer_list
	                    				]);
	                }
	            ],
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
                    'attribute' => 'subject_id',
                    'value' => function($data){
                        $x=$data->getSubjectname($data->subject_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', Questionset::getSubjectSortList($model->subject_id),['class'=>'form-control','prompt' => 'Select Subject']),
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
                [  
			        'class' => 'yii\grid\ActionColumn',
			        'template' => '{add}',
			        'buttons' => [
			            'add' => function ($url, $model) {
			                return Html::button('Remove', [
			                            'title' => 'Remove',
			                            'class'=>'btn btn-primary btn-xs add_item_btn',
			                            'data-url' => $url,
                                        'data-type' => 'remove'                                 
			                ]);
			            },
			        ],

			        'urlCreator' => function ($action, $model, $key, $index) {
			            
			                $url = Url::toRoute(['questionset/remove_item','id'=>$model->id,'sub_id'=>$model->subject_id]);
			                return $url;
				    }

			    ],
            ],
        	'export' => false,
        ]); ?>
    </div>
    <?php \yii\widgets\Pjax::end(); ?>



    <?php
    	\yii\widgets\Pjax::begin(
		    [
		        'enablePushState'=>FALSE,
		        'id' => 'questions_list'
		    ]
		);
    ?>
    <div class="questions_grid">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
	            [
	                'class' => 'kartik\grid\ExpandRowColumn',
	                'value' => function($model, $key, $index, $column){
	                    return GridView::ROW_COLLAPSED;
	                },
	                'detail' => function($model, $key, $index, $column){
	                	$answer_list = AnswerList::find()->where(['question_id'=>$model->id])->all();
	                    return Yii::$app->controller->renderPartial('_question_view',[
	                    					'model'=>$model,
	                    					'answer_list' => $answer_list
	                    				]);
	                }
	            ],
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
                    'attribute' => 'subject_id',
                    'value' => function($data){
                        $x=$data->getSubjectname($data->subject_id);
                        return $x;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'subject_id', Questionset::getSubjectSortList($model->subject_id),['class'=>'form-control']),
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
                [  
			        'class' => 'yii\grid\ActionColumn',
			        'template' => '{add}',
			        'buttons' => [
			            'add' => function ($url, $model) {
			                return Html::button('Add', [
			                            'title' => 'Add',
			                            'class'=>'btn btn-primary btn-xs add_item_btn',
			                            'data-url' => $url,
                                        'data-type' => 'add'                               
			                ]);
			            },
			        ],

			        'urlCreator' => function ($action, $model, $key, $index) {
			            
			                $url = Url::toRoute(['questionset/add_item','id'=>$model->id,'sub_id'=>$model->subject_id]);
			                return $url;
				    }

			    ],
            ],
        	'export' => false
        ]); ?>
    </div>

    <?php \yii\widgets\Pjax::end(); ?>
</div>


<?php

	$this->registerJs("
		

		$(document).delegate('.add_item_btn','click',function(){
			var url = $(this).attr('data-url');
            var type = $(this).attr('data-type');

            if(type == 'add'){
                add_remove_item(url);
            }else{
                BootstrapDialog.confirm({
                    title: 'WARNING',
                    message: 'Are you sure you want to '+type+' it?',
                    type: BootstrapDialog.TYPE_WARNING,
                    closable: false,
                    draggable: true,
                    btnCancelLabel: 'Do not '+type+' it!',
                    btnOKLabel: type+' it!',
                    callback: function(result) {
                        if(result) {
                            add_remove_item(url);
                        }else {
                            return false;
                        }
                    }
                });
            }

			return false;
		})


	function add_remove_item(url){
		var set = '".$model->question_set_id."';
		$.ajax({
            type : 'POST',
            dataType : 'json',
            url : url,
            data: {set:set},
            beforeSend : function( request ){
            	
            },
            success : function( data )
                {   
                	$('#w2').yiiGridView('applyFilter');
                	//$.pjax.reload({container:'#questions_added'});
                	setTimeout(function(){
                		$('#w1').yiiGridView('applyFilter');
                		//$.pjax.reload({container:'#questions_list'});
                	},1000);
                	

                }
        });

		return false;
	}

	", yii\web\View::POS_READY, "add_remove_item");

?>