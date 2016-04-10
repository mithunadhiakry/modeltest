<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	$this->title = 'Discounts';
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="discounts-index pane" style="float:left;width:100%;">

	<a class="discounts_height" href="<?= Url::toRoute(['discounts/index']);?>">Discounts</a>
	<a class="discounts_height" href="<?= Url::toROute(['user/give_points']);?>">User Free Points</a>

</div>