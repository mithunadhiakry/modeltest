
<?php
	foreach ($model as $key => $value) {
?>

	<div class="col-md-12">
		<div class="row">
			
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Subject</label>
					<input type="hidden" maxlength="255" name="Questionset[subject][<?= $key; ?>]" value="<?= $value->id; ?>" readonly="readonly" class="form-control">
					<input type="text" maxlength="255" name="gdf" value="<?= $value->subject_name; ?>" readonly="readonly" class="form-control">
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">No of question</label>
					<input type="text" maxlength="255" name="Questionset[no_of_question][<?= $key; ?>]" value="0" class="form-control checking_question">
				</div>
			</div>

		</div>
	</div>

<?php
	}
?>
