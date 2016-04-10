<div class="question-full">
	<div class="question-no">
		<div class="question_number">Question <?= $model->serial; ?> | </div>
	</div>
	<div class="questions_of_year"><?= $model->question->questions_of_year; ?></div>
	<div class="question-name">
		<?= $model->question->details; ?>
	</div>
</div>

<div class="anwer-list">
	<div class="answer-header">Answer</div>
	<?php
		foreach ($model->question->answer as $key) {
	?>

		<div class="answer-row">
			<input type="radio" class="answer_radio" name="answer_radio" value="<?= $key->id; ?>">
			<span>
				<?= $key->answer; ?>
			</span>
		</div>

	<?php
		}
	?>

</div>