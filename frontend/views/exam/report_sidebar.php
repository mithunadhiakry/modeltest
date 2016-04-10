<?php
	use yii\helpers\Url;
	use frontend\models\Rest;
	use frontend\models\User;
	use frontend\models\Questionset;
	use frontend\models\Userexamrel;
?>
<!-- <div class="inner_social_container">
    <a href="#" class="facebook">
        <span class="facebook_icon">
            <i class="fa fa-facebook"></i>
        </span>
    </a>
    <a href="#" class="googleplus">
        <span class="googleplus_icon">
            <i class="fa fa-google"></i>
        </span>
    </a>
    <a href="#">
        <span class="mail_icon">
            <i class="fa fa-envelope-o"></i>
        </span>
    </a>
</div> -->
<div class="report-container-1">
	

	<!-- Re Exam Modal -->
			
		<div class="modal fade" id="instruction_modal_reexam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		    <div class="modal-dialog modal-lg">
		        <div class="modal-content">
		        
		        <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
		        </div><!-- /modal-header -->
		        
		        <div class="modal-body">
		        	<!-- <div class="model_test_set_id"></div> -->
		     		<?php                           
		                if(!empty($get_page_data->post)){
		                    foreach($get_page_data->post as $post_data){
		                        echo $post_data->desc;
		                    }
		                }
		            ?>
		        </div><!-- /modal-body -->
		        
		        <div class="modal-footer text-right">
		        	<div class="start_exam_loader">
		        		<div class="css_loader_container_wrap">
							<div class="css_loader_container">
								<div class="cssload-loader"></div>
							</div>
						</div>
		        	</div>
		        	<div class="start_exam_popup_container">
						<div class="width100 start_exam_checkbox">
							<input type="checkbox" name="tick_to_make" id="tick_to_make_model_test">					
							<label for="tick_to_make_model_test">Tick to make sure you read & understand 'Instructions'.</label>
						</div>
						<div class="width100 start_exam_checkbox fb_share_button_for_exam">
							<input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_facebook">
							<label for="share_report_in_facebook">Share my report to my Facebook's personal wall, at the end of my exam.</label>
						</div>
						<div class="width100">
							<br/>
							Press <strong>Start Exam</strong> button  to begin the exam. All the best.
						</div>
		        	</div>
		        	<button type="button" class="btn btn-success reexam_btn_model_test">Start Exam</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		        </div><!-- /modal-footer -->
		        
		        </div><!-- /modal-content -->
		    </div><!-- /modal-dialog -->
		</div><!-- /modal -->

	<!-- Re Exam Modal -->

	
	<!-- Share pop up -->
		
		
			<div class="modal fade share_modal_content bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			    	<div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Share this exam</h4>
				    </div>

				    <div class="share_my_friend_container">
						 <form id="target" name="submit_friend_email" method="post" action="<?= Url::toRoute(['rest/assign_exam']); ?>">
							<div class="share_my_friend_box">
								<label>Friend's Email Address</label>
								<input class="email_address" type="email" name="email_address" required>
								<!-- <input type="hidden" name="assign_item" value="">
								<input type="hidden" name="exam_type"> -->
								<input type="hidden" name="exam_id" value="<?= $exam_data->exam_id; ?>">

							</div>
							<div class="share_my_friend_box_submit_button">
								<input type="submit" name="send" value="Send">
								
								<div class="share_the_exam_loader">
									<div class="css_loader_container_wrap">
										<div class="css_loader_container">
											<div class="cssload-loader"></div>
										</div>
									</div>
								</div>

							</div>
						 </form>
						 <div class="result"></div>
				    </div>

				    <div class="share_my_friend_list">
						<div class="col-md-12 header">
							<div class="row">
								<div class="col-md-5">Email Address</div>
								<div class="col-md-4">Status</div>
								<div class="col-md-3">Score</div>
							</div>
						</div>

						<?php
							if(!empty($assign_exam_list_r)){
								foreach($assign_exam_list_r as $assign_exam_list){
						?>
									<div class="col-md-12 content">
										<div class="row">
											<div class="col-md-5"><?= $assign_exam_list->assigntoUser->email; ?></div>
											<div class="col-md-4">
												<?php
													if($assign_exam_list->status){
														echo 'Completed';
													}else{
														echo 'Not completed';
													}
												?>
											</div>
											<div class="col-md-3">
												<?php	
												
													if(!empty($assign_exam_list->exam_id_of_attend)){
														echo Rest::get_mark($assign_exam_list->exam_id_of_attend) . ' %';																				
													}else{
														echo 'N/A';
													}																		
													
												?>
											</div>
										</div>
									</div>
						<?php	
								}
							}
						?>
						
				    </div>
			      		
		      		<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      		</div>
			      
			    </div>
			  </div>
			</div>

	<!-- Share pop up -->
	<div class="common-body">
		<div class="header exam-report-header">
			<i class="fa fa-book"></i>
			<span class="exam_report">Exam Report</span>
		</div>

		<div class="exam_report_container">
			<div class="exam-row">
				<div class="exam-label">
					Time of exam
				</div>

				<div class="text">
					<?php
						echo date_format(date_create($exam_data->created_at), 'd-m-Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($exam_data->created_at), 'g:i A');
					?>
				</div>
			</div>

			<div class="exam-row">
				<div class="exam-label">
					Assigned by
				</div>

				<div class="text">
					
					<?php
						if(!empty(\Yii::$app->user->identity)){
							$user_data = \Yii::$app->user->identity;
							if($user_data->id == $exam_data->assign_by){
								echo 'Myself';
							}else{
								$assign_user_data = User::find()
													->where(['id' => $exam_data->assign_by ])
													->one();
								echo $assign_user_data->name;
							}
						}
					?>
				</div>
			</div>



			<div class="exam-row">
				<div class="exam-label">
					Subject
				</div>

				<div class="text">
					<?php
						// Questionset
						if($exam_data->question_set_id == '1'){
							echo 'Previous exam';
						}else if($exam_data->question_set_id == '0'){
							echo 'Practice exam';
						}else{
							$question_set_name = Questionset::find()		
												->where(['question_set_id' => $exam_data->question_set_id ])
												->one();
							echo $question_set_name->question_set_name;
						}

					?>
				</div>
			</div>

			<div class="exam-row">
				<div class="exam-label">
					Time
				</div>

				<div class="text">
					<?php
						

						$init = $exam_data->exam_time;
						$hours = floor($init / 3600);
						$minutes = floor(($init / 60) % 60);
						$seconds = $init % 60;
						echo $exam_data->exam_time - $minutes . ' minutes ';
					?>
					
				</div>
			</div>

			
		</div>

		<div class="common-header report4parts">
			<a class="print_report" href="#">Save</a>
			<a class="reexam" exam-id="<?= $exam_data->exam_id ?>" href="#">Re Exam</a>
			<a href="#" id="open_popup_share_container" >Share</a>
			<!-- <a href="<?= Url::toRoute(['exam/print/'.$exam_data->exam_id]); ?>">Print</a> -->
			<a href="#" class="print_report">Print</a>
		</div>

	</div>


</div>



<?php

	$this->registerJs("
		
		$('#open_popup_share_container').on('click',function(){
			$('.share_modal_content').modal('show');
		});

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

                    $('.share_my_friend_list').append(data.assignment_data);
                    
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
		 

	", yii\web\View::POS_READY, "share_popup");
?>



<div class="print_wrap" style="display:none;">
	<div id="print_verification_letter">    
	    <div class="invoice_cont">
	        <style type="text/css">
	            @media print {
	                td.vendorListHeading {
	                    background-color: red !important;
	                    -webkit-print-color-adjust: exact; 
	                }
	                .heading_table{
	                	font-size:13px;float:left;width: 100%;
	                	font-family: "arial";
	                	color: #999;
	                }
	                .heading_table th{
	                	text-align: center;
	                	text-transform: uppercase;
	                	font-weight: normal;
	                	padding-bottom: 30px;
	                }
	                .heading_table td{
	                	padding: 5px;
	                	background: rgba(200,200,200,.1);
	                    -webkit-print-color-adjust: exact;
	                    font-size: 10px;
	                }
	                .content_table{
	                	font-size:13px;float:left;width: 100%;
	                	font-family: "arial";
	                	color: #999;
	                	border-top: 1px solid rgba(200,200,200,.3);
	                	border-left: 1px solid rgba(200,200,200,.3);
	                    -webkit-print-color-adjust: exact;
	                    margin-top: 30px;
	                }
	                .content_table td{
	                	border-bottom: 1px solid rgba(200,200,200,.3);
	                	border-right: 1px solid rgba(200,200,200,.3);
	                	color: #999;
	                    font-size: 10px;
	                    -webkit-print-color-adjust: exact;
	                    text-align: center;
	                }
	            }
	        </style>
	    	
	    	<table border="0" cellspacing="2" cellpadding="5" class="heading_table">
                <tr style="background-color:#213140;">
					<td colspan="4" style="text-align: center;">
						<img style="width: 230px;" src="http://dcastalia.com/projects/web/model_test/images/logo.png">
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
                <tr>
                	<th colspan="4">Summarize Report </th>
                </tr>
		    	<tr>
		    		<td width="20%">Name :</td>
		    		<td width="29%">
		    			<?= $exam_data->user->name; ?>
		    		</td>
		    		<td width="20%">Exam Type :</td>
		    		<td width="30%">
		    			<?php
							if($exam_data->question_set_id == '0'){
								echo 'Practice exam';
							}else if($exam_data->question_set_id == '1'){
								echo 'Previous Year';
							}else{
								echo 'Model Test';
							}
						?>
		    		</td>
		    	</tr>
		    	<tr>
		    		<td>Time taken :</td>
		    		<td>
		    			<?php 
							$init = $time_spent;
							$hours = floor($init / 3600);
							$minutes = floor(($init / 60) % 60);
							$seconds = $init % 60;

							echo $exam_data->exam_time - $minutes . ' minutes ';
							echo $seconds . ' seconds';
						?>
		    		</td>
		    		<td>Assign Date & Time :</td>
		    		<td>
		    			<?php
							echo date_format(date_create($exam_data->created_at), 'jS F Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($exam_data->created_at), 'g:i A');
						?>
					</td>
		    	</tr>
		    	

            </table>

            <table border="0" cellspacing="0" cellpadding="5" class="content_table">
               
                <?php if($exam_data->question_set_id == '0'){ ?>

                	<tr>
                		<td width="25%">Total Questions</td>
			    		<td width="25%"><?= $total_question; ?></td>
			    	</tr>
			    	<tr>
			    		<td>Answer</td>
			    		<td><?= $total_answer_number; ?></td>
                	</tr>
			    	<tr>
			    		<td>Correct</td>
			    		<td><?= $correct; ?></td>
                	</tr>

                	<tr>
                		<td>Incorrect</td>
			    		<td><?= $incorrect; ?></td>
			    	</tr>
			    	<tr>
			    		<td>Percentage</td>
			    		<td><?= $Percentage; ?> %</td>
                	</tr>


                <?php } else{

                		if($exam_data->question_set_id){

							$topper_score = 0.00;

							$exam_data_h_data = Userexamrel::find()->where(['question_set_id'=>$exam_data->question_set_id ])->all();
					        
					        foreach($exam_data_h_data as $exam_data_h){
					        	$question_list_h = \yii\helpers\Json::decode($exam_data_h->exam_questions);

					        	$total_question_h = count($question_list_h);
								$answered_h = 0;
								$correct_h = 0;
								$incorrect_h = 0;
								$score_h = 0;
								$Percentage_h = 0;

								if(isset($question_list_h)){

									foreach ($question_list_h as $question_h) {

										if($question_h['is_correct'] != 0 && $question_h['mark_for_review'] == 0){
											$answered_h++;

											if($question_h['is_correct'] == $question_h['answer_id']){
												$correct_h++;
												$score_h = $score_h+2;
												//echo $question['is_correct'].'.....'.$question['answer_id'].'<br/>';
											}else{
												$incorrect_h++;
												$score_h = $score_h-1;
											}
										}
									}

								}

								if($correct_h > 0){
									$Percentage_h = round(($correct_h*100)/$total_question_h,2);

									

									if($topper_score < $Percentage_h){
										$topper_score = $Percentage_h;
									}


								}




					        }
							
						}

                	?>

                	<tr>
			    		<td width="25%">Total Question</td>
			    		<td width="25%"><?= $total_question; ?></td>
			    		<td width="25%">Answer</td>
			    		<td width="25%"><?= $answered; ?></td>
			    	</tr>
			    	<tr>
			    		<td>Correct</td>
			    		<td><?= $correct; ?></td>
			    		<td>Incorrect</td>
			    		<td><?= $incorrect; ?></td>
			    	</tr>
			    	<tr>
			    		<td>Score</td>
			    		<td><?= $score; ?></td>
			    		<td>Prevoius Score</td>
			    		<td><?php echo $previous_score = Rest::get_previous_score($exam_data->exam_id);;?></td>
			    	</tr>
			    	<tr>
			    		<td>Percentage</td>
			    		<td><?= $Percentage; ?> %</td>
			    		<td>Attempts Time</td>
			    		<td><?php echo $number_of_attempts = $exam_data->no_of_time; ?></td>
			    	</tr>
			    	<tr>
			    		<td>Topper's score</td>
			    		<td>
			    			<?php

								if(isset($topper_score)){
									echo $topper_score. ' %';
								}else{
									echo 'N/A';
								}

							?>
			    		</td>
			    		<td>Time spend/ question</td>
			    		<td>
			    			<?php
			    				if($total_answer_number == 0){
			    					$init = $time_spent;
			    				}else{
			    					$init = $time_spent / $total_answer_number;
			    				}
			    				
								echo $seconds = $init % 60 .' seconds';
		    					

			    			?>
			    		</td>
			    	</tr>

                <?php } ?> 
		    	

		    	

            </table>

            <table>
            	<tr>
					<td colspan-"4">&nbsp;</td>
            	</tr>
            	<tr>
					<td colspan-"4">&nbsp;</td>
            	</tr>
            	<tr>
					<td colspan-"4">&nbsp;</td>
            	</tr>
				<tr style="font-size: 15px;width: 100%;">
					<?php
						if(!empty($advertisement_print_r)){
							foreach($advertisement_print_r as $advertisement_print){
					?>

								<td colspan="2">
									<img style="width: 100%;" src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement_print->image; ?>">
								</td>
					<?php
							}
						}
					?>
				</tr>
            </table>

	    </div>
	</div>
</div>


<?php
    $this->registerJs("
        $('.print_report').on('click',function(){
            PrintDiv();
            return false;
        });

        function PrintDiv() {    
           var divToPrint = $('#print_verification_letter');
           //console.log(divToPrint.html());
           var popupWin = window.open('', 'width=900,height=500');
           popupWin.document.open();
           popupWin.document.write('<html><body onload=\"window.focus(); window.print(); window.close()\">' + divToPrint.html() + '</html>');
            popupWin.document.close();
        }
        
                    
    ", yii\web\View::POS_READY, 'print');
?>

<?php
	$this->registerJs("
		var reexam = '';
		$('.reexam').on('click',function (e) {
			reexam = $(this).attr('exam-id');
			
			$('.model_test_set_id').html(reexam);
			$('#instruction_modal_reexam').modal('show');

            return false;
		});

	
		$('.reexam_btn_model_test').on('click',function(){

			if($('#share_report_in_facebook').prop('checked') == true){
				var share_facebook_report = 1;
			}else{
				var share_facebook_report = 0;
			}

			
			if($('#tick_to_make_model_test').prop('checked') == true){

				
			
				$.ajax({
		            type : 'POST',
		            dataType : 'json',
		            url : '".Url::toRoute('rest/start_exam_check_re_exam')."',
		            data: {share_facebook_report:share_facebook_report,exam_id:reexam},
		            beforeSend : function( request ){
		            	$('#instruction_modal_model_test .css_loader_container_wrap').fadeIn();
		            },
		            success : function( data )
		                {   
		                	$('#instruction_modal_model_test .css_loader_container_wrap').fadeOut();
		                	if(data.result == 'success'){
			                	window.location = data.redirect_url;
			                }
		                    else if(data.result == 'login_error'){
		                    	window.location = data.redirect_url;
		                    }else if(data.result == 'error'){
		                    	
		                    	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                    }
		                }
		        });

			}else{
		
				BootstrapDialog.alert({
								 title: 'WARNING',
								 'message': 'Please read the instruction carefully'
							});
			}
			
			
			return false;
		});



	", yii\web\View::POS_READY, "reexam_exam_with_modal");

?>
