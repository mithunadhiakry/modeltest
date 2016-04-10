
<?php
	use yii\helpers\Url;
	use frontend\models\Rest;
	use frontend\models\Userexamrel;
	use frontend\models\Questionset;
	use frontend\models\User;

	$this->title = 'Summarize Report | Model Test';

	//echo Yii::$app->params['model_test_plus_points'];
	
	if($exam_data->question_set_id == '0'){
		
		$plus_point = Yii::$app->params['practice_exam_plus_points'];
		$minus_point = Yii::$app->params['practice_exam_minus_points'];

	}else if($exam_data->question_set_id == '1'){
		

		if($exam_data->subject_course == '67'){
			$plus_point = Yii::$app->params['previous_exam_class_xi_xii_plus_points'];
			$minus_point = Yii::$app->params['previous_exam_class_xi_xii_minus_points'];
		}

		if($exam_data->subject_course == '68'){
			$plus_point = Yii::$app->params['previous_exam_admission_plus_points'];
			$minus_point = Yii::$app->params['previous_exam_admission_minus_points'];
		}

		if($exam_data->subject_course == '69'){
			$plus_point = Yii::$app->params['previous_exam_job_plus_points'];
			$minus_point = Yii::$app->params['previous_exam_job_minus_points'];
		}
		

	}else{
		
		$negative_positive_value = Questionset::find()->where(['question_set_id' => $exam_data->question_set_id ])->one();
		
		if(!empty($negative_positive_value)){

			$plus_point = $negative_positive_value->positive_point;
			$minus_point = $negative_positive_value->negative_point;

		}else{

			$plus_point = Yii::$app->params['model_test_plus_points'];
			$minus_point = Yii::$app->params['model_test_minus_points'];
		}
		
		

	}

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
							$score_h = $score_h+$plus_point;
							//echo $question['is_correct'].'.....'.$question['answer_id'].'<br/>';
						}else{
							$incorrect_h++;
							$score_h = $score_h-$minus_point;
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


	$total_question = count($question_list);
	$answered = 0;
	$correct = 0;
	$incorrect = 0;
	$score = 0;
	$Percentage = 0;
	$total_answer_number = 0;
	if(isset($question_list)){

		foreach ($question_list as $question) {
			if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
				$answered++;

				if($question['is_correct'] != 0){
					$total_answer_number++;
				}

				if($question['is_correct'] == $question['answer_id']){
					$correct++;
					$score = $score +$plus_point;
					//echo $question['is_correct'].'.....'.$question['answer_id'].'<br/>';
				}else{
					$incorrect++;
					$score = $score - $minus_point;
				}
			}
			
		}
		
	}
	

	if($correct > 0){
		$Percentage = round(($correct*100)/$total_question,2);
	}

	
	$time_spent = Rest::get_number_of_seconds_from_time($exam_data->time_spent);
	$number_of_attempts = $exam_data->no_of_time;
	$previous_score = Rest::get_previous_score($exam_data->exam_id);



	$init = $time_spent;
	$hours = floor($init / 3600);
	$minutes = floor(($init / 60) % 60);
	$seconds = $init % 60;
	
//exit();
?>
<!-- Start of report  -->
		
			<div class="container">
				<div class="inner_container">
					<div class="row">
						<div class="report_container margin-bottom-20">
							<div class="col-md-4 padding-left-0">
								<?=
									$this->render('report_sidebar',[
											'exam_data' => $exam_data,
											'assign_exam_list_r' => $assign_exam_list_r,
											'total_question' => $total_question,
											'answered' => $answered,
											'correct' => $correct,
											'incorrect' => $incorrect,
											'score' => $score,
											'Percentage' => $Percentage,
											'time_spent' => $time_spent,
											'question_list' => $question_list
										]);

								?>


								<div class="report-container-2 margin-top-20">


									<div class="common-header summarized-report-header-bg">
										<a href="<?= Url::toRoute(['batch/report','set_id'=>$exam_id]); ?>" class="width100">Question wise report</a>
									</div>

									
								</div>

								<div class="report-container-2 margin-top-20">


									<div class="common-header summarized-report-header-bg ">
										<a href="" class="width100 active">Summarize report</a>
									</div>

								</div>


							</div>

							<div class="col-md-8 padding-right-0">
							
							<div class="exam-report-question-section">

								<div class="report-summarize-container">
							
									<div class="width100-center">
										<div class="summarized-report-header">
											<i class="fa fa-book"></i>
											<span class="exam_report">Summarize Report</span>
										</div>
									</div>
	

									<div class="width100">

										
										<div class="report-user-summary">
											<div class="label">Name :</div>
											<div class="value"><?= $exam_data->user->name; ?></div>
										</div>

										<div class="report-user-summary">
											<div class="label">Exam Type :</div>
											<div class="value">
												<?php
													if($exam_data->question_set_id == '0'){
														echo 'Practice exam';
													}else if($exam_data->question_set_id == '1'){
														echo 'Previous Year';
													}else{
														echo 'Model Test';
													}
												?>
											</div>
										</div>

									
										<div class="report-user-summary">
											<div class="label">Time taken :</div>
											<div class="value">
												<?php 
													

													$init = $time_spent;
													$hours = floor($init / 3600);
													$minutes = floor(($init / 60) % 60);
													$seconds = $init % 60;
													echo $exam_data->exam_time - $minutes . ' minutes ';
													echo $seconds . ' seconds';
												?>


											</div>
										</div>

										<div class="report-user-summary">
											<div class="label">Assign Date & Time :</div>
											<div class="value">
												<?php
													echo date_format(date_create($exam_data->created_at), 'jS F Y').'&nbsp;&nbsp;&nbsp;'.date_format(date_create($exam_data->created_at), 'g:i A');
												?>
											</div>
										</div>

										

										

									</div>


									<div class="exam-report-basic-advanced-tab">
										
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active" <?php if($exam_data->question_set_id == '0'){ echo 'style="width:100%;"'; } ?>>
												<a href="#basicreport" aria-controls="home" role="tab" data-toggle="tab">Basic Report</a>
											</li>

											<?php if($exam_data->question_set_id != '0'){ ?>

												<li role="presentation" class="">
													<a href="#advancedreport" aria-controls="home" role="tab" data-toggle="tab">Advanced Report</a>
												</li>

											<?php }  ?>

											
										</ul>


										<div class="tab-content">
											<div role="tabpanel" class="tab-pane active" id="basicreport">
												
												<div class="basic-report-container">
													<div class="basic-report-row">
														<div class="basic-report-column">
															Total Questions
														</div>
														<div class="basic-report-column">
															<?= $total_question; ?>
														</div>			
													</div>

													<div class="basic-report-row">
														<div class="basic-report-column">
															Answer
														</div>
														<div class="basic-report-column">
															<?= $total_answer_number; ?>
														</div>			
													</div>
													<div class="basic-report-row">
														<div class="basic-report-column">
															Correct
														</div>
														<div class="basic-report-column">
															<?= $correct; ?>
														</div>			
													</div>

													<div class="basic-report-row">
														<div class="basic-report-column">
															Incorrect
														</div>
														<div class="basic-report-column">
															<?= $incorrect; ?>
														</div>			
													</div>

													<div class="basic-report-row">
														<div class="basic-report-column">
															Percentage
														</div>
														<div class="basic-report-column">
															<?= $Percentage; ?> %
														</div>			
													</div>

													

												</div>

												<!-- <div class="nb-container-exam-report">
													Note: 'Not answered question' refered as incorrect answer. Correct answer score 2 and incorrect answer score -1.
												</div> -->

											</div>

											<div role="tabpanel" class="tab-pane" id="advancedreport">
												
												<div class="basic-report-container">
													

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Total Question
														</div>
														<div class="basic-report-column">
															<?= $total_question; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Answer 
														</div>
														<div class="basic-report-column">
															<?= $answered; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Correct 
														</div>
														<div class="basic-report-column">
															<?= $correct; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Incorrect 
														</div>
														<div class="basic-report-column">
															<?= $incorrect; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Score 
														</div>
														<div class="basic-report-column">
															<?= $score; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Prevoius Score 
														</div>
														<div class="basic-report-column">
															<?= $previous_score; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Percentage 
														</div>
														<div class="basic-report-column">
															<?= $Percentage; ?> %
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Attempts Time 
														</div>
														<div class="basic-report-column">
															<?= $number_of_attempts; ?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Topper's score
														</div>
														<div class="basic-report-column">
															<?php

																if(isset($topper_score)){
																	echo $topper_score. ' %';

																	if($topper_score > 80 && $number_of_attempts ==1){

																		$point = Rest::get_point_from_point_table('above_80');
																		Rest::save_transaction_history($exam_data->user_id,$point,'+','above_80','');
																		$user_data = User::find()->where(['id'=>$exam_data->user_id])->one();

																		$user_data->free_point = $user_data->free_point + $point;
																        
																        $user_data->save();

																	}
																	
																}else{
																	echo 'N/A';
																}

															?>
														</div>			
													</div>

													<div class="basic-report-row advanced-report-row">
														<div class="basic-report-column">
															Time spend / question
														</div>
														<div class="basic-report-column">
															<?php 


															$init = $time_spent / $total_answer_number;
															echo $seconds = $init % 60 .' seconds';

															?> 
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
					</div>
				</div>
			</div>

		<!-- end of report -->