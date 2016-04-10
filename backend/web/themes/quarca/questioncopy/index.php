<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use kartik\widgets\DepDrop;

use backend\models\Country;
use backend\models\Subject;
use backend\models\Category;
use backend\models\Chapter;

$this->title = 'Question Copy';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    yii\widgets\Pjax::begin(['id' => 'questioncopy_pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);
?>



<?php 
	$from = $model->from_country.'-'.$model->from_category.'-'.$model->from_subcategory.'-'.$model->from_subject.'-'.$model->from_chapter;
	echo '<span class="from_str hide">'.$from.'</span>';
	$to = $model->to_country.'-'.$model->to_category.'-'.$model->to_subcategory.'-'.$model->to_subject.'-'.$model->to_chapter;
	echo '<span class="to_str hide">'.$to.'</span>';

	$form = ActiveForm::begin([
			'method' => 'post',
	        'options' => ['data-pjax' => true ],
	        'id' => 'questioncopy',
	]); ?>
	<div class="pane">
	    <div class="page-form">
	        <div id="wizard">
	            <section class="first_step">
	                <div class="row">
	                    <div class="col-md-6">
							<div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Country Name</label>
						            
						                <?php
						                    echo $form->field($model, 'from_country')->widget(Select2::classname(), [
						                        'data' => Country::get_all_country_list(),
						                        'options' => ['placeholder' => 'Select a country ...','multiple'=>false],
						                        'pluginOptions' => [
						                            'allowClear' => true
						                        ],
						                    ])->label(false);    
						                ?>
						            
						        </div>
						    </div>
						    
						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Category Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'from_category')->widget(DepDrop::classname(), [
						                        'data'=> Category::get_all_category_list(),
						                        'options' => ['placeholder' => 'Select a category ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-from_country'],
						                            'url' => Url::to(['/question/getchildcategories']),
						                            'loadingText' => 'Loading category ...',
						                        ]
						                    ])->label(false);   
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Sub Category Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'from_subcategory')->widget(DepDrop::classname(), [
						                        'data'=> Category::get_all_sub_category_list(),
						                        'options' => ['placeholder' => 'Select a category ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-from_category'],
						                            'url' => Url::to(['/question/getsubcategories']),
						                            'loadingText' => 'Loading sub category ...',
						                        ]
						                    ])->label(false);   
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Subject Name</label>
						            
						                <?php
						                    echo $form->field($model, 'from_subject')->widget(DepDrop::classname(), [
						                        'data'=> Subject::get_all_subject_list(),
						                        'options' => ['placeholder' => 'Select a subject ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>false]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-from_subcategory'],
						                            'url' => Url::to(['/question/getchildsubjects']),
						                            'loadingText' => 'Loading subjects ...',
						                        ]
						                    ])->label(false);
						                       
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Chapter Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'from_chapter')->widget(DepDrop::classname(), [
						                        'data'=> Chapter::get_all_chapter_list(),
						                        'options' => ['placeholder' => 'Select a chapter ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-from_subject'],
						                            'url' => Url::to(['/question/getchildchapters']),
						                            'loadingText' => 'Loading chapter ...',
						                        ]
						                    ])->label(false);
						                       
						                ?>
						            
						        </div>

						        <?php
							    	echo Html::submitButton('Get Data', ['class' => 'btn btn-primary']);
							    ?>
						    </div>


						</div>


						<div class="col-md-6">
							<div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Country Name</label>
						            
						                <?php
						                    echo $form->field($model, 'to_country')->widget(Select2::classname(), [
						                        'data' => Country::get_all_country_list(),
						                        'options' => ['placeholder' => 'Select a country ...','multiple'=>false],
						                        'pluginOptions' => [
						                            'allowClear' => true
						                        ],
						                    ])->label(false);    
						                ?>
						            
						        </div>
						    </div>
						    
						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Category Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'to_category')->widget(DepDrop::classname(), [
						                        'data'=> Category::get_all_category_list(),
						                        'options' => ['placeholder' => 'Select a category ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-to_country'],
						                            'url' => Url::to(['/question/getchildcategories']),
						                            'loadingText' => 'Loading category ...',
						                        ]
						                    ])->label(false);   
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Sub Category Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'to_subcategory')->widget(DepDrop::classname(), [
						                        'data'=> Category::get_all_sub_category_list(),
						                        'options' => ['placeholder' => 'Select a category ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-to_category'],
						                            'url' => Url::to(['/question/getsubcategories']),
						                            'loadingText' => 'Loading sub category ...',
						                        ]
						                    ])->label(false);   
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Subject Name</label>
						            
						                <?php
						                    echo $form->field($model, 'to_subject')->widget(DepDrop::classname(), [
						                        'data'=> Subject::get_all_subject_list(),
						                        'options' => ['placeholder' => 'Select a subject ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>false]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-to_subcategory'],
						                            'url' => Url::to(['/question/getchildsubjects']),
						                            'loadingText' => 'Loading subjects ...',
						                        ]
						                    ])->label(false);
						                       
						                ?>
						            
						        </div>
						    </div>

						    <div class="col-md-12">
						        <div class="form-group">
						            <label class="control-label" for="userfront-country">Chapter Name</label>
						            
						                
						                <?php
						                    echo $form->field($model, 'to_chapter')->widget(DepDrop::classname(), [
						                        'data'=> Chapter::get_all_chapter_list(),
						                        'options' => ['placeholder' => 'Select a chapter ...'],
						                        'type' => DepDrop::TYPE_SELECT2,
						                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						                        'pluginOptions'=>[
						                            'depends'=>['copyqueston-to_subject'],
						                            'url' => Url::to(['/question/getchildchapters']),
						                            'loadingText' => 'Loading chapter ...',
						                        ]
						                    ])->label(false);
						                       
						                ?>
						            
						        </div>
						    </div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

<?php ActiveForm::end(); ?>

<div class="row">
	<div class="col-md-6">
		<div class="pane">
	        <div class="row">
	        	<div class="btn_panel">
	        		<a data-pjax="false" href="" class="from_copy btn btn-sm btn-primary pull-right margin-right-5" style="background:rgb(243, 80, 43);">Copy &amp; Paste</a>
	        		<a data-pjax="false" href="" class="from_check_none btn btn-sm btn-primary pull-right margin-right-5">Select None</a>
	        		<a data-pjax="false" href="" class="from_check_all btn btn-sm btn-primary pull-right margin-right-5">Select All</a>
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="col-md-12">
	        					<div class="col-md-12">
	        					<input type="text" class="form-control from_search" placeholder="Search question" style="width:100%; padding:0 10px; margin-top:10px; font-size:12px;">
	        					</div>
	        				</div>
	        			</div>
	        		</div>
	        	</div>
            	<div class="from_content">
	            	<?php
	            		if(!empty($from_data)){
	            			foreach ($from_data as $key => $value) {
	            	?>
	            		<div class="q_item show">
	            			<div class="q_check"><?= Html::checkbox('from_check_'.$value->id,false,['data-item'=>$value->id]); ?></div>
	            			<div class="q_details"><?= $value->details; ?></div>
	            		</div>
	            	<?php
	            			}
	            		}
	            	?>
            	</div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="pane">
	        <div class="row">
	        	<div class="btn_panel">
	        		<a data-pjax="false" href="" class="to_remove btn btn-sm btn-primary pull-right margin-right-5" style="background:rgb(243, 80, 43);">Remove</a>
	        		<a data-pjax="false" href="" class="to_check_none btn btn-sm btn-primary pull-right margin-right-5">Select None</a>
	        		<a data-pjax="false" href="" class="to_check_all btn btn-sm btn-primary pull-right margin-right-5">Select All</a>
	        		<div class="row">
	        			<div class="col-md-12">
	        				<div class="col-md-12">
	        					<div class="col-md-12">
	        					<input type="text" class="form-control to_search" placeholder="Search question" style="width:100%; padding:0 10px; margin-top:10px; font-size:12px;">
	        					</div>
	        				</div>
	        			</div>
	        		</div>
	        	</div>
            	<div class="to_content">
	            	<?php
	            		if(!empty($to_data)){
	            			foreach ($to_data as $key => $value) {
	            	?>
	            		<div class="q_item show">
	            			<div class="q_check"><?= Html::checkbox('to_check_'.$value->id,false,['data-item'=>$value->id]); ?></div>
	            			<div class="q_details"><?= $value->details; ?></div>
	            		</div>

	            	<?php
	            			}
	            		}
	            	?>
            	</div>
			</div>
		</div>
	</div>
</div>


<?php yii\widgets\Pjax::end() ?> 

<style type="text/css">
	.from_content,.to_content{
		height: 400px;
		overflow: auto;
		padding: 0 15px;
	}
	.q_item{
		float: left;
		width: 100%;
		padding: 5px 0;
		border-bottom:1px solid #ccc;
	}
	.q_check{
		width: 20px;
		float: left;
	}
	.q_check > input{
		float: left;
	}
	.q_details{
		width: -moz-calc(100% - 20px);
		width: -webkit-calc(100% - 20px);
		width: -ms-calc(100% - 20px);
		width: -o-calc(100% - 20px);
		width: calc(100% - 20px);
		float: left;
	}
	.margin-right-5{
		margin-right: 10px;
	}
	.btn_panel{
		height: 90px;
		width: 100%;
		float: left;
	}

</style>

<?php
    

    $this->registerJs("
    	$(document).delegate('.from_search','change',function(){
    		var val = $(this).val();
    		if(val.length == 0){
    			$('.from_content .q_item').removeClass('show');
    			$('.from_content .q_item').removeClass('hide');
    			console.log(val.length);
    		}
    		else{
    			$('.from_content .q_item').removeClass('show');
    			$('.from_content .q_item').addClass('hide');

	    		$('.from_content p:contains(\"'+val+'\")').each(function(){
		     		if($(this).children().length < 1) {
		          		$(this).closest('.q_item').addClass('show');
		          		$(this).closest('.q_item').removeClass('hide');
		          		console.log($(this));
		     		}
		        });
    		}
    		
    	});

		$(document).delegate('.to_search','change',function(){
    		var val = $(this).val();
    		if(val.length == 0){
    			$('.to_content .q_item').removeClass('show');
    			$('.to_content .q_item').removeClass('hide');
    			console.log(val.length);
    		}
    		else{
    			$('.to_content .q_item').removeClass('show');
    			$('.to_content .q_item').addClass('hide');

	    		$('.to_content p:contains(\"'+val+'\")').each(function(){
		     		if($(this).children().length < 1) {
		          		$(this).closest('.q_item').addClass('show');
		          		$(this).closest('.q_item').removeClass('hide');
		          		console.log($(this));
		     		}
		        });
    		}
    		
    	});

        $(document).delegate('.from_check_all', 'click', function () {
            $('.from_content .show input[type=\"checkbox\"]').prop('checked', true);
            return false;
        });

    	$(document).delegate('.from_check_none', 'click', function () {
            $('.from_content .show input[type=\"checkbox\"]').prop('checked', false);
            return false;
        });

    	$(document).delegate('.to_check_all', 'click', function () {
            $('.to_content .show input[type=\"checkbox\"]').prop('checked', true);
            return false;
        });

    	$(document).delegate('.to_check_none', 'click', function () {
            $('.to_content .show input[type=\"checkbox\"]').prop('checked', false);
            return false;
        });

    	$(document).delegate('.from_copy', 'click', function () {
            var ids = [];
            var from = $('.from_str').html();
            var to = $('.to_str').html();

            $('.from_content input:checked').each(function(index,value){
            	ids.push($(value).attr('data-item'));
            });
            
            $.ajax({
                url: '".Url::toRoute(['questioncopy/copy_questions'])."',
                type: 'post',
                dataType: 'json',
                data: {from:from,to:to,ids:ids},
                beforeSend: function(){
                    $('#loader_modal').modal('show');
                },
                success: function (response) {
                    //$('#loader_modal').modal('hide');

                    if(response.result == 'success'){
                        setTimeout(function(){
                        	$('#questioncopy').submit();
                        },500);
                    }
                    else{
                        
                        console.log(response.msg);
                    }
                }
            });

            return false;
        });

		$(document).delegate('.to_remove', 'click', function () {
            var ids = [];
            var from = $('.from_str').html();
            var to = $('.to_str').html();

            $('.to_content input:checked').each(function(index,value){
            	ids.push($(value).attr('data-item'));
            });

			BootstrapDialog.confirm({
                    title: 'WARNING',
                    message: 'Are you sure you want to remove?',
                    type: BootstrapDialog.TYPE_WARNING,
                    closable: false,
                    draggable: true,
                    btnCancelLabel: 'Do not remove!',
                    btnOKLabel: 'Remove!',
                    callback: function(result) {
                        if(result) {
                            
                        	$.ajax({
				                url: '".Url::toRoute(['questioncopy/remove_questions'])."',
				                type: 'post',
				                dataType: 'json',
				                data: {ids:ids},
				                beforeSend: function(){
				                    $('#loader_modal').modal('show');
				                },
				                success: function (response) {
				                    //$('#loader_modal').modal('hide');

				                    if(response.result == 'success'){
				                        setTimeout(function(){
				                        	$('#questioncopy').submit();
				                        },500);
				                    }
				                    else{
				                        
				                        console.log(response.msg);
				                    }
				                }
				            });

                        }else {
                            return false;
                        }
                    }
                });
            
            

            return false;
        });

    ", yii\web\View::POS_READY, 'check');

	$this->registerJs("


    	$('#questioncopy_pjax').on('pjax:send', function() {
		  $('#loader_modal').modal('show');
		});
		$('#questioncopy_pjax').on('pjax:complete', function() {
		  $('#loader_modal').modal('hide');
		  	
		});
    ", yii\web\View::POS_READY, 'check2');

?>