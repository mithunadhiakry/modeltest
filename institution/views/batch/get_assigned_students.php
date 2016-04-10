<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
?>
<table class="table table-striped table-bordered">
	<tr>
		<th>Student Id</th>
		<th>Model Test</th>
		<th>Score</th>
		<th>Status</th>
		<th></th>
	</tr>

	<?php
		if(!empty($get_all_assigned_exam_r)){
	?>
		
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
							echo $get_all_assigned_exam->courseName->question_set_name;
						?>
					</td>
					<td>0%</td>
					<td>
						<?php
							if($get_all_assigned_exam->status == '1'){
								echo 'Attend';
							}else{
								echo 'Not Attend';
							}
						?>
					</td>
					<td>
						<?php
							if($get_all_assigned_exam->exam_id_of_attend != ''){
								echo '<a href="'.Url::toRoute(['batch/report','set_id'=>$get_all_assigned_exam->exam_id_of_attend]).'" class="btn btn-primary btn-xs">View</a>';
							}else{
								echo 'N/A';
							}
						?>
						
					</td>
				</tr>
	<?php
			}
	

		}

	?>
</table>