<?php

	use  yii\web\Session;

	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;

	use \kartik\grid\GridView;
	use yii\helpers\ArrayHelper;
	use kartik\select2\Select2;
	use kartik\widgets\DepDrop;
	use kartik\widgets\TouchSpin;

	use institution\models\Country;
	use institution\models\Category;

?>

<?php $form = ActiveForm::begin(); ?>

   <div class="col-md-12">

            <div class="col-md-3">
                <?= $form->field($model, 'question_set_name')->textInput(['maxlength' => 255]) ?>
            </div>

            <div class="col-md-3">
                <?php
                    echo $form->field($model, 'exam_time')->widget(TouchSpin::classname(), [
                        'options'=>['placeholder'=>'Exam time in minutes'],
                            'pluginOptions' => [
                                'verticalbuttons' => true,
                                'min' => 0,
                                'max' => 100,
                                'buttonup_class' => 'btn btn-primary', 
                                'buttondown_class' => 'btn btn-info', 
                                'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                                'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                            ]
                    ])
                ?>
            </div>

            <div class="col-md-3">
                <?php
                    echo $form->field($model, 'pasue')
                            ->dropDownList(
                                [
                                    '1'=>'On', 
                                    '0'=>'Off'
                                ],           // Flat array ('id'=>'label')
                                ['prompt'=>'']    // options
                            );
                ?>
            </div>

             <div class="col-md-3">
                <?php
                    echo $form->field($model, 'deduct_on_pause')->widget(TouchSpin::classname(), [
                        'options'=>['placeholder'=>'Enter rating 1 to 5...'],
                            'pluginOptions' => [
                                'verticalbuttons' => true,
                                'initval' => 0,
                                'min' => 0,
                                'max' => 100,
                                'buttonup_class' => 'btn btn-primary', 
                                'buttondown_class' => 'btn btn-info', 
                                'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                                'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                            ]
                    ])
                ?>
            </div>

   </div>

	

     <div class="col-md-3">      
            
        <?php
            echo $form->field($model, 'country_id')->widget(Select2::classname(), [
                'data' => Country::get_all_country_list(),
                'options' => ['placeholder' => 'Select a country ...','multiple'=>false],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);    
        ?>            
       
    </div>

    <div class="col-md-3">               
        <?php
            echo $form->field($model, 'category_id')->widget(DepDrop::classname(), [
                'data'=> Category::get_all_category_list(),
                'options' => ['placeholder' => 'Select a category ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['questionset-country_id'],
                    'url' => Url::to(['/question/getchildcategories']),
                    'loadingText' => 'Loading category ...',
                ]
            ]);   
        ?>
	</div>

	<div class="col-md-3">
                
                    
        <?php
            echo $form->field($model, 'sub_category_id')->widget(DepDrop::classname(), [
                'data'=> Category::get_all_sub_category_list(),
                'options' => ['placeholder' => 'Select a category ...'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['questionset-category_id'],
                    'url' => Url::to(['/question/getsubcategories']),
                    'loadingText' => 'Loading sub category ...',
                ],
                'pluginEvents' => [
                    'change'=>"function(event, id, value, count) { 
                        console.log($(this).val());
                        get_subjects($(this).val());
                    }",
                ]
            ]);   
        ?>
    

	</div>


        <?php
            // echo $form->field($model, 'status')
            //         ->dropDownList(
            //             [
            //                 '1'=>'Active', 
            //                 '0'=>'Inactive'
            //             ],           // Flat array ('id'=>'label')
            //             ['prompt'=>'Select Status']    // options
            //         );
        ?>


    <div class="col-md-3">
        <?php
            echo $form->field($model, 'type')
                    ->dropDownList(
                        [
                            'Manual'=>'Manual', 
                            'Automated'=>'Automated'
                        ],           // Flat array ('id'=>'label')
                        ['prompt'=>'Select type']    // options
                    );
        ?>
    </div>

    <div class="pane" style="float:left; width:100%; margin-top:0;">
        <div class="subjects_list">
            <?php
                if(!empty($model->subject)){
                    foreach ($model->subject as $key => $value) {
                        $subject = Subject::find()->where(['id'=>$value['subject_id']])->one();
            ?>

                <div class="col-md-12">
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Subject</label>
                                <input type="hidden" maxlength="255" name="Questionset[subject][<?= $key; ?>]" value="<?= $value['subject_id']; ?>" readonly="readonly" class="form-control">
                                <input type="text" maxlength="255" name="gdf" value="<?= $subject->subject_name; ?>" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">No of question</label>
                                <input type="text" maxlength="255" name="Questionset[no_of_question][<?= $key; ?>]" value="<?= $value['no_of_question']; ?>" class="form-control">
                            </div>
                        </div>

                    </div>
                </div>

            <?php
                    }
                }
            ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php

    $this->registerJs("

    function get_subjects(sub_cat_id){
        
        $.ajax({
            type : 'POST',
            dataType : 'json',
            url : '".Url::toRoute(['questionset/get_subjects'])."',
            data: {sub_cat_id:sub_cat_id},
            beforeSend : function( request ){
                
            },
            success : function( data )
            {   
                if(data.result == 'success'){
                    $('.subjects_list').html(data.message);
                }
            }
        });

        return false;
    }

    ", yii\web\View::POS_END, "add_remove_item");

?>