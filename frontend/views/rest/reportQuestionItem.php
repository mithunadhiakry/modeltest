<div class="question-full">
	<div class="question-no">
		<div class="question_number">Question <?= $model['serial']; ?> .  </div>		
	</div>
	<div class="questions_of_year"><?= $question->questions_of_year; ?></div>
	<div class="question-name">
		<?= $question->details; ?>
	</div>
</div>

<div class="anwer-list">

	<?php
		$answers = $question->answer;
		if(!empty($answers)){
			foreach ($answers as $key) {

	?>

		<div class="answer-row">
			
			

			<div class="report-answer-list-container">
				<!-- <input type="radio" name="answer"> -->

				<div class="report-answer-list-correct-incorrect">
					<?php
						if($key->is_correct == 1 && $key->id == $model['is_correct']){
					
							echo '<div class="correct-answer">Correct answer</div>';
					
						}else{
							if($key->is_correct == 1){
								echo '<div class="correct-answer">Correct answer</div>';
							}
							elseif($key->id == $model['is_correct']){
								echo '<div class="your-answer">Your answer</div>';
							}
							else{
								echo '&nbsp;';
							}
						}
					?>

				</div>


				<?php
					if($key->is_correct == 1 && $key->id == $model['is_correct']){
				
						echo '<span class="active">';
				
					}else{
						if($key->is_correct == 1){
							echo '<span class="active">';
						}
						elseif($key->id == $model['is_correct']){
							echo '<span class="in-correct">';
						}
						else{
							echo '<span>';
						}
					}
				?>


				
					<input type="radio" name=""  value="" checked="checked" />
					<div class="question_option_container">
						<?= $key->answer; ?>
					</div>

				</span>
				
			</div>


		</div>

	<?php
			}
		}
	?>
	

</div>