<?php
	use yii\helpers\Url;
	use yii\widgets\LinkPager;

	use frontend\models\Userexamrel;
	use frontend\models\Questionset;
?>	
<?php
	$this->title = 'Dashboard | Model Test';

?>

<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="report_container margin-bottom-20">
				<div class="col-md-4 padding-left-0">
					<div class="report-container-1">
						<div class="common-header">
							<div class="width100 dashboard-profile-header">Profile</div>
						</div>

						<div class="common-body">
							
							<div class="exam_report_container">

								<div class="profile-pic">
									<?php
		                                if(!empty($user_data->image)){
		                            ?>
		                                <img src="<?= Url::base('') ?>/user_img/<?= $user_data->image ?>">
		                            <?php  }else{ ?>
		                                <img src="<?= Url::base('') ?>/images/profile_avater.jpg">
		                            <?php  }  ?>
								</div>
								<div class="profile_detail">
									<?= $user_data->name ?><br/>
									<?= $user_data->email ?><br/>
									<?= $user_data->phone ?><br/><br/>
									<?= $user_data->address ?>
								</div>
								<div class="exam-row">
									
									
								</div>
								
								<a href="<?= Url::toRoute(['user/view?tab=personal_details']); ?>" class="view_my_profile">View profile</a>
																
							</div>
						</div>
					</div>



				</div>


				<div class="col-md-8 padding-right-0">
					<div class="exam-report-question-section " style="padding:0;">
						
						<div class="col-md-4 padding-left-0">
							<div class="dashboard-box">
								<div class="dashboard_icon">
									<i class="fa fa-columns"></i>
								</div>
								<div class="dashboard_right">
									Total Exam Attended <br/> <?= $total_exam_attended ?>
								</div>
							</div>


						</div>

						<div class="col-md-4 padding-left-0 padding-right-0">
							<div class="dashboard-box">
								<div class="dashboard_icon ">
									<i class="fa fa-columns"></i>
								</div>
								<div class="dashboard_right">
									My Top Score<br/> 

									<?php
									
									if(count($question_list) > 0 && !empty($question_list)){

											$total_question = count($question_list);

											$correct = 0;											
											$Percentage = 0;
											$answered = 0;
											$get_height_value = array();

											foreach ($question_list as $question) {
												if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
													$answered++;

													if($question['is_correct'] == $question['answer_id']){
														$correct++;
														$Percentage = round(($correct*100)/$total_question,2);
											
														array_push($get_height_value, $Percentage);
														
													}else{
														$incorrect = 0;
													}
												}
												
											}

										
										if(count($get_height_value) == 0){
											echo '0.00 %';
										}else{
											echo max($get_height_value) . ' %';
										}
										

									}else{
										echo '0.00 %';
									}
										
									?>
								</div>
							</div>


						</div>


						<div class="col-md-4 padding-right-0">
							
							<div class="dashboard-box">
								<div class="dashboard_icon ">
									<i class="fa fa-money"></i>
								</div>
								<div class="dashboard_right">
									Point Remaining <br/> <?= $sum_of_points + $user_data->free_point ?>
								</div>
							</div>
						</div>

						<div class="col-md-12 padding-right-0 padding-left-0">
							
							<div class="dashboard-box">
								<div class="dashboard_icon ">
									<i class="fa fa-money"></i>
								</div>
								<div class="dashboard_right points_remain_table">
									<table class="table table-striped table-bordered">
										<tr>
											<th>Package</th>
											<th>Expire Date</th>
											<th>Points Remaining</th>
										</tr>
										<?php
											if(!empty($packages_info)){
												foreach ($packages_info as $package) {
										?>

											<tr>
												<td><?= $package->package_name; ?></td>
												<td><?= $package->expired_date; ?></td>
												<td><?= $package->points; ?></td>
											</tr>

										<?php
												}
											}
										?>
										<tr>
											<td>Free</td>
											<td>N/A</td>
											<td><?= Yii::$app->user->identity->free_point; ?></td>
										</tr>
									</table>
								</div>
							</div>

						</div>



					</div>
				</div>


				<div class="col-md-12 margin-top-30">
					<div class="row">
						<div class="activity-log-container">
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#activity_log_tab" aria-controls="home" role="tab" data-toggle="tab">Activity Log</a></li>
    							<li role="presentation"><a href="#awaited_exam_tab" aria-controls="profile" role="tab" data-toggle="tab">Awaited exams
    								<?php
    									if(count($my_assing_exam_list) > 0):
    								?>
    										<span class="awaited_exam_num"><?= count($my_assing_exam_list); ?></span></a>
    								<?php
    									endif;
    								?>
    							</a>
    							</li>
							</ul>

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="activity_log_tab">
									<div class="landing_activity_log_tab">

										<table class="table">
											<thead>
												<tr>
													<th>Exam Subject/Course</th>
													<th>Exam type</th>
													<th>Assign by</th>
													<th>Time & date to assign</th>
													<th>Exam status</th>
													<th>Report</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$temp_date = date('Y-m-d', strtotime('tomorrow'));
													foreach($exams as $get_activity_log){
												?>
														<?php
															if($temp_date != date_format(date_create($get_activity_log->created_at), 'Y-m-d')){
														?>
														<tr>
															<td colspan="6" class="text-align-center">
																<?php
																	$attended_date = $get_activity_log->created_at;
																    if (strtotime($attended_date) >= strtotime("today")){
																    	echo "Today";
																    }else if(strtotime($attended_date) >= strtotime("yesterday")){
																    	echo "Yesterday";
																    }else{
																    	echo date('Y-m-d', strtotime($attended_date));
																    }
																        
																?>
															</td>
														</tr>
														<?php
															}
														?>
												
														<tr>
															<td>
																<?php
																	if($get_activity_log->question_set_id == '0'){
																		echo 'General Test';
																	}
																	elseif($get_activity_log->question_set_id == '1'){
																		echo 'Previous Year';
																	}else{
																		echo $get_activity_log->questionset->question_set_name;
																	}
																?>
															</td>
															<td>
																<?php
																	if($get_activity_log->question_set_id == '0'){
																		echo 'General Test';
																	}
																	elseif($get_activity_log->question_set_id == '1'){
																		echo 'Previous Year';
																	}else{
																		echo 'Model Test';
																	}
																?>
															</td>
															<td>
																<?php
																	if($get_activity_log->assign_by == $user_data->id){
																		echo 'MySelf';
																	}else{
																		echo $get_activity_log->assignbyUser->name;
																	}
																?>
															</td>
															<td>
																<?php
																	
																	echo $get_activity_log->created_at;
																?>
															</td>
															<td>Completed</td>
															<td><a class="view view_exam_report" href="<?= Url::toRoute(['exam/report/'.$get_activity_log->exam_id]); ?>">View</td>
														</tr>
												<?php
															
														$temp_date = date_format(date_create($get_activity_log->created_at), 'Y-m-d');
													}
												?>
												
												<tr>
													<td colspan="6">&nbsp;</td>
												</tr>

												<?php
													if(count($exams) > 10):
												?>
												<tr>
													<td colspan="6">
														<a class="floatright view" href="<?= Url::toRoute(['user/history']); ?>">View more activity log</a>
													</td>
												</tr>

											<?php endif; ?>
												
												
											</tbody>
										</table>
										<div class="container-fluid">
											<?php
												 // LinkPager::widget(['pagination' => $exam_rows,
													// 					'lastPageLabel'=>false,
													// 					'firstPageLabel'=>false,
													// 		            'prevPageLabel' => 'Prev',
													// 		            'nextPageLabel' => 'Next',
													// 		            'maxButtonCount' =>5
										   //       ]) 
									        ?>
										</div>
									</div>

								</div>
								<div role="tabpanel" class="tab-pane" id="awaited_exam_tab">
									
									<div class="landing_activity_log_tab">

										<table class="table">
											<thead>
												<tr>
													<th>Exam Subject/Course</th>
													<th>Exam type</th>
													<th>Assign by</th>
													<th>Time & date to assign</th>
													<th style="text-align:center;">Question amount</th>
													<th>Exam status</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if(!empty($my_assing_exam_list)){
														foreach($my_assing_exam_list as $my_assing_exam){
												?>
															<tr>
																<td>
																	<?php
																		if($my_assing_exam->question_set_id == '0' || $my_assing_exam->question_set_id == ''){
																			echo 'General Test';
																		}
																		elseif($my_assing_exam->question_set_id == '1'){
																			echo 'Previous Year';
																		}else{
																			
																			if(!empty($my_assing_exam->questionset->question_set_name)){
																				echo $my_assing_exam->questionset->question_set_name;
																			}
																		}
																	?>
																</td>
																<td>
																	<?php
																		if($my_assing_exam->question_set_id == '0'){
																			echo 'General Test';
																		}
																		elseif($my_assing_exam->question_set_id == '1'){
																			echo 'Previous Year';
																		}else{
																			echo 'Model Test';
																		}
																	?>
																</td>
																<td><?= $my_assing_exam->assignbyUser->name; ?></td>
																<td><?= $my_assing_exam->time; ?></th>
																<td style="text-align:center;">
																	<?
																		if(isset($my_assing_exam->get_exam->number_of_question)){
																			echo $my_assing_exam->get_exam->number_of_question;	
																		}  
																	?>
															</td>
																<?php 

																	if($my_assing_exam->exam_id == ''){
																		$ass_exam = $my_assing_exam->question_set_id;
																		$ass_type = 'admin';
																		$url_ass = Url::toRoute('rest/start_exam_check_assigned_exam_admin');
																	}else{
																		$ass_exam = $my_assing_exam->exam_id;
																		$ass_type = '';
																		$url_ass = Url::toRoute('rest/start_exam_check_assigned_exam');
																	}

																?>
																<td><a class="start_exam view_exam_report" data-type="<?= $ass_type; ?>" exam-id="<?= $ass_exam; ?>" href="<?= $url_ass; ?>">Start Exam</a></td>
															</tr>
												<?php
														}
													}
												?>												
											</tbody>
										</table>

										<div class="modal fade" id="instruction_modal_model_test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
										    <div class="modal-dialog modal-lg">
										        <div class="modal-content">
										        
										        <div class="modal-header">
										            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
										        </div><!-- /modal-header -->
										        
										        <div class="modal-body">

										        	<div class="exam_instruction_container">
											        	<!-- <div class="model_test_set_id"></div> -->
											     		<?php                           
											                if(!empty($get_page_data->post)){
											                    foreach($get_page_data->post as $post_data){
											                        echo $post_data->desc;
											                    }
											                }
											            ?>
											        </div>

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
														<div class="width100 start_exam_checkbox">
															<input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_facebook">
															<label for="share_report_in_facebook">Share my report to my Facebook's personal wall, at the end of my exam.</label>
														</div>
														<div class="width100">
															<br/>
															Press <strong>Start Exam</strong> button  to begin the exam. All the best.
														</div>
										        	</div>
										        	<button type="button" class="btn btn-success start_exam_btn_model_test">Start Exam</button>
										            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										        </div><!-- /modal-footer -->
										        
										        </div><!-- /modal-content -->
										    </div><!-- /modal-dialog -->
										</div><!-- /modal -->
										
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$this->registerJs("
		var start_exam = '';
		var ass_url = '';
		$('.start_exam').on('click',function (e) {
			start_exam = $(this).attr('exam-id');
			ass_url = $(this).attr('href');
			
			$('.model_test_set_id').html(start_exam);
			$('#instruction_modal_model_test').modal('show');

            return false;
		});

	
		$('.start_exam_btn_model_test').on('click',function(){
			
			if($('#share_report_in_previous_year_facebook').prop('checked') == true){
				var share_facebook_report = 1;
			}else{
				var share_facebook_report = 0;
			}
			
			if($('#tick_to_make_model_test').prop('checked') == true){
			
				$.ajax({
		            type : 'POST',
		            dataType : 'json',
		            url : ass_url,
		            data: {share_facebook_report:share_facebook_report,exam_id:start_exam},
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



	", yii\web\View::POS_READY, "start_exam_with_modal");

?>