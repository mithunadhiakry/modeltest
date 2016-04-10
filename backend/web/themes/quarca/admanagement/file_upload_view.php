
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use backend\models\AdManagement;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $PostImageRel_model = new AdManagement(); ?>
        <?= FileInput::widget([
            'model' => $PostImageRel_model,
            'attribute' => 'image',
            'options'=>[
                'multiple'=>true
            ],
            'pluginOptions' => [
                'uploadUrl' => Url::to(['/admanagement/upload_file']),
                'uploadExtraData' => [
                    'id' => $post_id,
                    'cat_id' => 'Nature'
                ],
                'maxFileCount' => 1,
                'allowedFileExtensions' => ['jpg', 'png'],
            ],
            'pluginEvents' => [
                'fileuploaded'=>'function(event, data, previewId, index){
                    $(".uploaded_post_image_cont").html(data.response.view);
                    
                }',
                'filebatchuploadcomplete' => 'function(event, files, extra){
                    $(".fileinput-remove-button").click();
                }'
            ]
        ]);
    ?>
