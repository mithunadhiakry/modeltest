<?php
	use yii\helpers\Url;



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
					if($get_activity_log->assign_by == $user_id){
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
			<td><a class="view" href="<?= Url::toRoute(['exam/report/'.$get_activity_log->exam_id]); ?>">View</td>
		</tr>
<?php
			
		$temp_date = date_format(date_create($get_activity_log->created_at), 'Y-m-d');
	}
?>