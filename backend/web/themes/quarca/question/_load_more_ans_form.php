<div class="col-md-12" id="item-<?= $key; ?>">
    <div class="col-md-9">
        <div class="form-group field-answerlist-<?= $key; ?>-answer required">
			<label for="anseditor<?= $key; ?>" class="control-label">Option <?= $key+1; ?></label>
			<textarea rows="2" name="AnswerList[<?= $key; ?>][answer]" class="form-control" id="anseditor<?= $key; ?>"></textarea>
			<div class="help-block"></div>

		</div>    
	</div>
 	<div class="col-md-2">
        <div class="form-group field-answerlist-<?= $key; ?>-is_correct">

			<div class="checkbox">
				<input type="hidden" value="0" name="AnswerList[<?= $key; ?>][is_correct]">
				<label>
					<input type="checkbox" value="1" name="AnswerList[<?= $key; ?>][is_correct]" id="answerlist-<?= $key; ?>-is_correct"> 
					Is Correct?
				</label>
			</div>
			<div class="help-block"></div>
		</div>
	</div>
	<div class="col-md-1">
        <input type="button" class="btn btn-sm btn-primary pull-right remove_ans" id="<?= $key; ?>" value="x">
    </div>
</div>