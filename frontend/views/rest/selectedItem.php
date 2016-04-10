<?php
	
	use yii\helpers\Url;
	
?>

<li class="selected_item<?= $model->id; ?>">
	<?= $model->chaper_name; ?> <span class="selected_subject_name">(<?= $model->subject->subject_name; ?>)</span>
	<span class="remove remove_selected_chapter" data-selected-id="<?= $model->id; ?>">
		<img src="<?= Url::base('') ?>/images/cross_1.png">
	</span>
</li>