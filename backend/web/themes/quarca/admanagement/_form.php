<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="post-form">
    <?php $form = ActiveForm::begin([
        'id' => 'post-form',
        'action' => ['admanagement/create'],
        'enableAjaxValidation' => false,
        'enableClientValidation' =>  true,
        
    ]); ?>

    
    <input type="hidden" name="AdManagement[ad_identifier]" value="<?php if(isset($ad_identifier)){echo $ad_identifier;} ?>">
    <?= $form->field($model, 'ad_name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ad_description')->textArea(['rows' => '6','id'=>'editor1']) ?>
    
    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')
                                    ->dropDownList(
                                    array ('1'=>'Active', '0'=>'Inactive') 
                                ); 
                    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success c_p' : 'btn btn-primary c_p']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php

    $this->registerJs("
            $(document).ready(
                    $(document).delegate('#post-form', 'beforeSubmit', function(event, jqXHR, settings) {
                        
                            var form = $(this);
                            if(form.find('.has-error').length) {
                                    return false;
                            }
                            
                            $.ajax({
                                    url: form.attr('action'),
                                    type: 'post',
                                    data: form.serialize(),
                                    success: function(data) {
                                        dt = jQuery.parseJSON(data);

                                        if(dt.result=='success'){
                                            $('.list_of_post').html(dt.post_list);
                                            $('.post_sort').sortable();
                                            
                                            $('#post-form')[0].reset();
                                            CKEDITOR.instances.editor1.setData('');
                                            alertify.log('AD has been saved successfully.', 'success', 5000);
                                        }else{
                                            
                                            alertify.log(dt.files, 'error', 5000);
                                        }
                                    }
                            });
                            
                            return false;
                    })
            );

    ", yii\web\View::POS_END, 'post_submit');

    
    $this->registerJs('
            
            CKEDITOR.replace( "editor1", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "'.Url::base().'/kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "'.Url::base().'/kcfinder/upload.php?type=flash"
            });
    ', yii\web\View::POS_READY, 'ck_editor_post');


?>
