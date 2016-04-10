<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>

<div class="pane">
    <div class="page-form">
        <div id="wizard">
            <section class="first_step">
                <div class="row">
                    <div class="category-form pane">
                        
                        <?php $form = ActiveForm::begin(); ?>
                            
                            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                            
                            <?= $form->field($model, 'short_description')->textInput(['maxlength' => 255]) ?>
                                                        
                            <?= $form->field($model, 'description')->textArea(['rows' => '6','id'=>'editor_blog']) ?>

                            <?= $form->field($model, 'status')
                                ->dropDownList(
                                    array ('1'=>'Active', '0'=>'Inactive') 
                                ); ?>

                            

                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success floatright' : 'floatright btn btn-primary']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php

    $this->registerJs('
            
            CKEDITOR.replace( "editor_blog", {
                 customConfig: "'.Url::base().'/ckeditor/config/'.Yii::$app->params["editor"].'/config.js",
                 filebrowserBrowseUrl: "kcfinder/browse.php?type=files",
                 filebrowserImageBrowseUrl: "kcfinder/browse.php?type=images",
                 filebrowserFlashBrowseUrl: "kcfinder/browse.php?type=flash",
                 filebrowserUploadUrl: "kcfinder/upload.php?type=files",
                 filebrowserImageUploadUrl: "kcfinder/upload.php?type=images",
                 filebrowserFlashUploadUrl: "kcfinder/upload.php?type=flash"
            });

    ', yii\web\View::POS_READY, 'ck_editor_blog');

?>