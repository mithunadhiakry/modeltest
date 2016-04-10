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

$this->title = 'Add Question';
$this->params['breadcrumbs'][] = ['label' => 'Questionsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model_set->id, 'url' => ['view', 'id' => $model_set->id]];
$this->params['breadcrumbs'][] = 'Update';

$success_msg = '';
if(\Yii::$app->getSession()->hasFlash('success')){
	$success_msg = \Yii::$app->getSession()->getFlash('success');
}

?>
<div class="questionset-update">


    <?= $this->render('_add_question_form', [
        'model' => $model,'ans_model'=>$ans_model
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
                'id',
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
                'status',
                [  
			        'class' => 'yii\grid\ActionColumn',
			        'template' => '{add}',
			        'buttons' => [
			            'add' => function ($url, $model) {
			                return Html::button('Delete', [
			                            'title' => 'Delete',
			                            'class'=>'btn btn-primary btn-xs delete_item_btn',
			                            'data-url' => $url,
                                        'data-type' => 'delete'                                 
			                ]);
			            },
			        ],

			        'urlCreator' => function ($action, $model, $key, $index) {
			            
			                $url = Url::toRoute(['customquestionset/delete_question','id'=>$model->id]);
			                return $url;
				    }

			    ],
            ],
        	'export' => false,
        ]); ?>
    </div>
    <?php \yii\widgets\Pjax::end(); ?>



</div>


<?php
	$this->registerJs("
		var success_msg = '".$success_msg."';
		if(success_msg != ''){
			BootstrapDialog.show({
				type: BootstrapDialog.TYPE_SUCCESS,
	            title: 'Message',
	            message: success_msg
	        });
		}
		$(document).delegate('.delete_item_btn','click',function(){
			var url = $(this).attr('data-url');

            BootstrapDialog.confirm({
                title: 'WARNING',
                message: 'Are you sure you want to delete it?',
                type: BootstrapDialog.TYPE_WARNING,
                closable: false,
                draggable: true,
                btnCancelLabel: 'Do not delete it!',
                btnOKLabel: 'Delete it!',
                callback: function(result) {
                    if(result) {
                        delete_item(url);
                    }else {
                        return false;
                    }
                }
            });

			return false;
		})

	function delete_item(url){

		$.ajax({
            type : 'POST',
            dataType : 'json',
            url : url,
            data: {},
            beforeSend : function( request ){
            	
            },
            success : function( data )
                {   
                	if(data.result=='success'){
                		$('#w0').yiiGridView('applyFilter');
	                	//$.pjax.reload({container:'#questions_added'});
	                	
                	}
                	
                	BootstrapDialog.show({
			            title: 'Message',
			            message: data.msg
			        });

                }
        });

		return false;
	}

	", yii\web\View::POS_READY, "add_remove_item");
?>