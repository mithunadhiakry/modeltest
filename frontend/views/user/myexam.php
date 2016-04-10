<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	use frontend\models\Userexamrel;
	use frontend\models\Questionset;

	$this->title = 'My Exam | Model Test';
?>

<div class="container">
	<div class="row">
		<div class="inner_container">
			
			<div class="common-header margin-top-30 margin-bottom-30">
				<a href="#" class="width100">My Model Test</a>
			</div>

			<ul class="dashboard-my-latest-exam my-exam-list">
				<?php
					$get_recent_test_taker = Userexamrel::getmy_model_test($model->id,'9999');

					if(isset($get_recent_test_taker)){
						foreach($get_recent_test_taker as $latest_taker){ 
							
							$question_list = \yii\helpers\Json::decode($latest_taker->exam_questions);
							$total_question = count($question_list);

							$correct = 0;
		                    $answered = 0;
		                    $Percentage = 0;
		                    foreach ($question_list as $question) {
		                        if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
		                            $answered++;

		                            if($question['is_correct'] == $question['answer_id']){
		                                $correct++;
		                            }
		                        }
		                        
		                    }

		                    $Percentage = round(($correct*100)/$total_question,2);

							$modeltestname = Questionset::find()
												->where(['question_set_id' => $latest_taker->question_set_id])
												->andWhere(['!=','question_set_id','1'])
												->one();
					?>
							<li>
								<a href="<?= Url::toRoute(['exam/report/'.$latest_taker->exam_id]); ?>">
									<span class="subject">
										<?php
											if(isset($modeltestname)){
												echo  $modeltestname->question_set_name;
											}	
										 ?>
									</span>
									<span class="my-mark"><?= $Percentage . ' %' ?></span>
								</a>
							</li>
					<?php
						}
				}
				?>
			</ul>
		</div>
	</div>
</div>

