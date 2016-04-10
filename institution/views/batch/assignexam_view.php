<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	use kartik\select2\Select2;

	use institution\models\Questionset; 
?>
<div class="modal-header">
    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
    <h4 id="myModalLabel" class="modal-title">Assign Exam</h4>
</div>

<div class="share_my_friend_container">
	<?php
        $form = ActiveForm::begin(
            [      
                'action' => Url::base().'/batch/setassignexam',                  
                'options' => [
                    'class' => 'set_assign_exam'
                ]
            ]
        );
    ?>
	 
		<div class="share_my_friend_box">
			<label>Model Test</label>
			<?php
		        echo $form->field($model, 'question_set_name')->widget(Select2::classname(), [
		            'data' => Questionset::get_all_question_list(),
		            'options' => ['placeholder' => 'Select a question set ...'],
		            'pluginOptions' => [
		                'allowClear' => true
		            ],
		        ])->label(false);    
		    ?>
			
			<!-- <input type="hidden" name="assign_item" value="">
			<input type="hidden" name="exam_type"> -->
			<input type="hidden" name="batch_id" value="<?= $batch_id; ?>">
			<input type="hidden" name="course_id" value="<?= $course_id; ?>">


		</div>
		<div class="share_my_friend_box_submit_button">
			<!-- <button>Send</button> -->
			<input type="submit" name="" value="Send">
			
			<div class="share_the_exam_loader">
				<div class="css_loader_container_wrap">
					<div class="css_loader_container">
						<div class="cssload-loader"></div>
					</div>
				</div>
			</div>

		</div>
	 <?php ActiveForm::end(); ?>
	 <div class="result"></div>
</div>

<div class="view_lists_of_all_assigned_user">
	<table class="table table-striped table-bordered">
		<tr>
			<th>Student Id</th>
			<th>Model Test</th>
			<th>Score</th>
			<th>Status</th>
		</tr>
	
		
		</table>
	</div>

<?php

	$this->registerJs("
		
		
		$( '.set_assign_exam' ).submit(function( event ) {

		  var form = $(this);
		  $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                beforeSend : function( request ){
		           	$('.share_the_exam_loader .css_loader_container_wrap').fadeIn();
		        },
                success: function(data) {
                	$('.share_the_exam_loader .css_loader_container_wrap').fadeOut();

                    $('.result').html(data.msg);

                    location.reload();
					
                    //$('.view_lists_of_all_assigned_user table').append(data.successmsg);
                    
                    if(data.assignment_data){
                    	$('.email_address').html('');
                    }
                    
                    setTimeout(function() {
                        $('.result').html('');
                    }, 4000);
                }
	        });
		  event.preventDefault();
		});
		 

	", yii\web\View::POS_READY, "send_question_to_user");
?>