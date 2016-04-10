<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use institution\models\User;
use kartik\widgets\DepDrop;
use institution\models\Courses;
use institution\models\Batch;

/* @var $this yii\web\View */
/* @var $model institution\models\Students */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php
        echo $form->field($model, 'student_email')->widget(Select2::classname(), [
            'data' => User::get_all_student_list(),
            'options' => ['placeholder' => 'Select a student ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);    
    ?>
    
    <?php
        echo $form->field($model, 'course_id')->widget(Select2::classname(), [
            'data' => Courses::get_all_course_list(),
            'options' => ['placeholder' => 'Select a course ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);    
    ?>
    
    <?php
        echo $form->field($model, 'batch_no')->widget(DepDrop::classname(), [
            'data'=> Batch::get_all_batch_list(),
            'options' => ['placeholder' => 'Select a batch ...'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
            'pluginOptions'=>[
                
                'depends'=>['students-course_id'],
                'url' => Url::to(['/students/getbatchdata']),
                'loadingText' => 'Loading batch ...',
            ]
        ]);   
    ?>
    

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
