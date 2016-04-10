<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\select2\Select2;
use institution\models\Courses;

/* @var $this yii\web\View */
/* @var $model institution\models\Batch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="batch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'batch_no')->textInput(['maxlength' => 100]) ?>
    
    <?php
        echo $form->field($model, 'course_id')->widget(Select2::classname(), [
            'data' => Courses::get_all_course_list(),
            'options' => ['placeholder' => 'Select a course ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);    
    ?>
    
    <?= $form->field($model, 'course_start')->textInput() ?>

    <?= $form->field($model, 'course_end')->textInput() ?>

    <?php
        $data = array ('1'=>'Active', 
                       '0'=>'Inactive'
                        );
        echo $form->field($model, 'status')
                ->dropDownList(
                    $data,           // Flat array ('id'=>'label')
                    ['prompt'=>'Select Status']    // options
                );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
    $this->registerJs("
        
        $('#batch-course_start').datepicker({
            'format' : 'yyyy-mm-dd'
        });

        $('#batch-course_end').datepicker({
            'format' : 'yyyy-mm-dd'
        });

    ", yii\web\View::POS_READY, "set_batch_course_start_end");
?>