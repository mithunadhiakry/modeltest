<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Questionset */

$this->title = 'Create Questionset';
$this->params['breadcrumbs'][] = ['label' => 'Questionsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
	<div class="row">
		<div class="inner_container">

			<div class="ac_point account_ac_point">
		    	<h3>Add a new question set</h3>		    	
	    	</div>


	    	<div class="add-new-course-container">
				<div class="col-md-12">
					<?= $this->render('_form', [
				        'model' => $model,
				    ]) ?>
				</div>
	    	</div>
		</div>
	</div>
</div>