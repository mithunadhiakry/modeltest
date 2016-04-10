<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'enableClientValidation' => false]); ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                            <?= $model->isNewRecord?$form->field($model, 'username')->textInput(['maxlength' => 255]):'' ?>
                            <?= $form->field($model, 'address')->textArea(['rows' => '7']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                            <?= $model->isNewRecord?$form->field($model, 'password')->textInput(['maxlength' => 255]):''; ?>

                            <?php
                                $data_user_type = array ('admin'=>'Admin',
                                                        'student'=>'Student', 
                                                        'institution'=>'Institution'
                                                );
                                echo $form->field($model, 'user_type')
                                        ->dropDownList(
                                            $data_user_type,           // Flat array ('id'=>'label')
                                            ['prompt'=>'Select User Type','class'=>'form-control user_type']    // options
                                        );
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
                            
                            <?php if($model->isNewRecord): ?>
                                <?= $form->field($model, 'image')->fileInput() ?>
                            <?php endif; ?>

                        </div>

                        <div class="col-md-12">
                            <h3>User Details</h3>
                        </div>

                        <div class="col-md-12">
                            
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                               <?php
                                    $data_gender = array ('Male'=>'Male',
                                                            'Female'=>'Female'
                                                    );
                                    echo $form->field($details_model, 'gender')
                                            ->dropDownList(
                                                $data_gender,           
                                                ['prompt'=>'Select Gender','class'=>'form-control gender']    // options
                                            );
                                ?>
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'date_of_birth')->textInput(['maxlength' => 255]) ?>    
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>    
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'education')->textInput(['maxlength' => 255]) ?>    
                            </div>
                           <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'institution_name')->textInput(['maxlength' => 255]) ?>    
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'employee_status')->textInput(['maxlength' => 255]) ?>    
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'employee_organization')->textInput(['maxlength' => 255]) ?>    
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'how_do_you_know_about_modeltest')->textArea(['rows' => '4']) ?>
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'your_expectation')->textArea(['rows' => '4']) ?>
                            </div>
                            <div class="col-md-6 student_cont admin_cont toggle_user_type">
                                <?= $form->field($details_model, 'recommended_other')->textArea(['rows' => '4']) ?>
                            </div>
                            
                        </div>


                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <?= Html::submitButton(($model->isNewRecord)?'Create':'Update', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </div>
</div>


<?php

    $this->registerJs("
        var initial_val = $('.user_type').val();
        $('.'+initial_val+'_cont').show();

        $('.user_type').on('change', function() { 
            var value = $(this).val();

            $('.toggle_user_type').hide();
            $('.'+value+'_cont').show();
        });
    ", yii\web\View::POS_READY, 'chage_type');

     $this->registerJs("
        
        
        jQuery('#userdetails-date_of_birth').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '-16425d',
            endDate: '-3652d'
        });



    ", yii\web\View::POS_READY, "date_of_birth_datepicker");

     $this->registerJs("

        $.mask.definitions['~']='[(0)]';
        $('#user-phone').mask('(+88)-~999-9999-999');

    ", yii\web\View::POS_READY, 'mobile_number_validation'); 
?>
