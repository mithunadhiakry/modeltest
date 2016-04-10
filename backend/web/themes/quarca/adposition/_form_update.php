<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use backend\models\AdManagement;
use backend\models\AdPosition;

/* @var $this yii\web\View */
/* @var $model backend\models\AdPosition */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Url::base()."/files/html.sortable_product_image.js", ['depends' => [\yii\web\JqueryAsset::className()]]);

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
                                <?= $this->render('/admanagement/list_of_post', [
                                    'page_id' => $model->id
                                ]) ?>
                            </div>
                            <div class="col-md-12" style="margin-top:30px;">
                                <div class="row post_sort_order_wrap">
                                    <!-- <input type="button" class="btn btn-sm btn-primary pull-right post_sort_order" value="Save Ad "> -->
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
        <h4 class="modal-title" id="myModalLabel">Create Ad</h4>
      </div>
      <div class="modal-body">
                <div class="post">
                    <?php 
                        $post_model = new AdManagement();
                    ?>
                    <?= $this->render('/admanagement/_form', [
                        'model' => $post_model,
                        'ad_identifier' => $model->id
                    ]) ?>
                </div>
      </div>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal_post_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Ad</h4>
      </div>
      <div class="modal-body">
                
      </div>
      
    </div>
  </div>
</div>

<div class="modal fade" id="myModal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Update Add</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
            <div class="post">
                <?php 
                    $post_model = new AdManagement();
                ?>
                <?= $this->render('/admanagement/_form_update', [
                    'model' => $post_model,
                    'ad_identifier' => $model->id
                ]) ?>
            </div>
        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
    </div><!-- /modal -->

<?php

    $this->registerJs("
        $('.post_sort').sortable();
        
        $(document).delegate('.view_post_btn', 'click', function() { 
            var id = $(this).attr('data_id');
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('admanagement/view')."',
                data: {id:id},
                beforeSend : function( request ){
                    $('#myModal_post_view .modal-body').html('');
                    $('#myModal_post_view .modal-body').addClass('loader');
                    $('#myModal_post_view').modal('show');
                },
                success : function( data )
                    {   
                        $('#myModal_post_view .modal-body').removeClass('loader');
                        $('#myModal_post_view .modal-body').html(data.view);
                         
                    }
            });
            return false;
        });
    ", yii\web\View::POS_READY, 'view_post_btn');

    $this->registerJs("
        $(document).delegate('.update_post_btn', 'click', function() { 
            var id = $(this).attr('data_id');

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute('admanagement/update')."',
                data: {id:id},
                beforeSend : function( request ){},
                success : function( data )
                    { 
                        
                        $('#myModal_update #admanagement-ad_name').val(data.ad_name);
                        $('#myModal_update #AdManagementid').val(data.id);
                        CKEDITOR.instances.editor3.setData(data.ad_description);
                        $('#myModal_update #admanagement-url').val(data.url);
                        $('#image_tab_cont').html(data.upload_view);
                        $('.uploaded_post_image_cont').html(data.images_list);
                        $('#myModal_update').modal('show');
                    }
            });
            return false;
        });
    ", yii\web\View::POS_END, 'update_post_btn');
	
	$this->registerJs("
        $(document).delegate('.create_post', 'click', function() { 
            $('#myModal').modal('show');
        });
    ", yii\web\View::POS_END, 'create_post');


    $this->registerJs("
        $(document).delegate('.delete_post_btn', 'click', function() {
            var id = $(this).attr('data_id');

            BootstrapDialog.confirm({
                title: 'WARNING',
                message: 'Are you sure you want to delete it?',
                type: BootstrapDialog.TYPE_WARNING,
                closable: false,
                draggable: true,
                btnCancelLabel: 'Do not delete it!',
                btnOKLabel: 'Delete it!',
                callback: function(result) {
                    if(result) {
                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('admanagement/delete')."',
                            data: {id:id},
                            beforeSend : function( request ){
                            },
                            success : function( data )
                                {   
                                    $('.Post_'+id).remove();
                                     
                                }
                        });
                    }else {
                        return false;
                    }
                }
            });
            
            
            return false;
        });
    ", yii\web\View::POS_READY, 'delete_post_btn');

?>