<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use backend\models\AdManagement;

/* @var $this yii\web\View */
/* @var $model backend\models\AdPosition */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>

<div class="pane with_float">
    <div id="wizard">
		<ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General Info</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Ad Section</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
				<?php $form = ActiveForm::begin(); ?>
                
                    <div class="col-md-12">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                        <?= $form->field($model, 'identifier')->textInput(['maxlength' => 255]) ?>
                        <?= $form->field($model, 'description')->textArea(['rows' => '6','id'=>'editor_ad_position']) ?>
                        <?= $form->field($model, 'status')
                                        ->dropDownList(
                                        array ('1'=>'Active', '0'=>'Inactive') 
                                    ); 
                        ?>

                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success floatright' : 'floatright btn btn-primary']) ?>
                    </div>

                   

                <?php ActiveForm::end(); ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="settings">
				
				
				<section>
                    
                    <div class="col-md-12">
                        <div class="pane">
                            <input type="button" class="btn btn-sm btn-default create_post" value="Create Ad">
                            
                            <div class="list_of_post">
                                <?= $this->render('/post/list_of_post', [
                                    'page_id' => $model->id
                                ]) ?>
                            </div>
                            <div class="col-md-12" style="margin-top:30px;">
                                <div class="row post_sort_order_wrap">
                                    <input type="button" class="btn btn-sm btn-primary pull-right post_sort_order" value="Save Ad ">
                                </div>
                            </div>
                            
                            <label></label>
                        </div>
                    </div>

                </section>
			

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Post</h4>
      </div>
      <div class="modal-body">
                <div class="post">
                    <?php $post_model = new AdManagement(); ?>
                    <?= $this->render('/adpoisition/_ad_form', [
                        'model' => $post_model,
                        'page_id' => $model->id
                    ]) ?>
                </div>
      </div>

    </div>
  </div>
</div>

<?php
	
	$this->registerJs("
        $(document).delegate('.create_post', 'click', function() { 
            $('#myModal').modal('show');
        });
    ", yii\web\View::POS_END, 'create_post');

?>