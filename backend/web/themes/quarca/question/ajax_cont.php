<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tabular Input test';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->params['adminEmail'];
//echo Yii::$app->params['theme'];
?>

<?php

		$form = ActiveForm::begin(['id' => 'answer_list_form']);
                                  
          echo TabularForm::widget([
              'dataProvider'=>$dataProvider,
              'form'=>$form,
              'attributes'=>$model_q->formAttribs,
              'gridSettings'=>[
                  'floatHeader'=>true,
                  'panel'=>[
                      'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
                      'type' => GridView::TYPE_PRIMARY,
                      'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class'=>'btn btn-success add_ans_btn']) . ' ' . 
                              //Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class'=>'btn btn-danger']) . ' ' .
                              Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary tabular_save_btn'])
                  ]
              ]   
          ]);
          ActiveForm::end();

?>	