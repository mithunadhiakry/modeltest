<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Questionset */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Questionsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="questionset-view pane">
	<div class="question_set_container">
		<label>Name of the Question Set:</label> &nbsp;&nbsp; <?= $model->question_set_name; ?>
	</div>
	<div class="question_set_assign_user">
		<form id="target" name="submit_friend_email" method="post" action="<?= Url::toRoute(['questionset/assign_exam']); ?>">
			
			<div class="share_my_friend_box">
				<label>Student's Email Address</label>
				<input class="email_address" type="email" name="email_address" required>
				<!-- <input type="hidden" name="assign_item" value="">
				<input type="hidden" name="exam_type"> -->
				<input type="hidden" name="exam_id" value="<?= $model->question_set_id; ?>">

			</div>
			<div class="share_my_friend_box_submit_button">
				<input class="btn btn-success question_sub_btn" type="submit" name="send" value="Send">
				<div class="result"></div>
				<div class="share_the_exam_loader">
					<div class="css_loader_container_wrap">
						<div class="css_loader_container">
							<div class="cssload-loader"></div>
						</div>
					</div>
				</div>

			</div>


		</form>

	</div>

	<div class="view_lists_of_all_assigned_user">
		<?php
			if(!empty($get_all_assigned_exam_r)){
		?>
			<table class="table">
				<tr>
					<th>Student Email</th>
					<th>Status</th>
				</tr>
		<?php
				foreach($get_all_assigned_exam_r as $get_all_assigned_exam){
		?>

					<tr>
						<td>
							<?php
								echo $get_all_assigned_exam->assigntoUser->email;
							?>
						</td>
						<td>
							<?php
								if($get_all_assigned_exam->status == '1'){
									echo 'Attend';
								}else{
									echo 'Not Attend';
								}
							?>
						</td>
					</tr>
		<?php
				}
		?>
			</table>
		<?php

			}

		?>
	</div>
</div>

<?php

	$this->registerJs("
		
		
		$( '#target' ).submit(function( event ) {

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

                    $('.view_lists_of_all_assigned_user table').append(data.successmsg);
                    
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