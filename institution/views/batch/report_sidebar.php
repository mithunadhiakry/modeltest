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

	</div>


</div>


