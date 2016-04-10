<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model institution\models\Batch */

$this->title = 'Update Batch: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="ac_point account_ac_point">
		    	<h3><?= Html::encode($this->title) ?></h3>		    	
	    	</div>
			
			<div class="add-new-course-container">
	    		<div class="col-md-6 padding-left-0">
					<?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				</div>

				<div class="col-md-6">
					<div class="ad">
						<img src="<?= Url::base(); ?>/images/ad.png">
					</div>
				</div>

	    	</div>

		</div>
	</div>
</div>