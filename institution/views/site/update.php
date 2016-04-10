<?php
	use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
use kartik\file\FileInput;

    use frontend\models\UserNotificationRel;
    use frontend\models\User;

    $user_model = new User();

    $this->title = "Update Profile | Model Test";
?>
<div class="container ">
    <div class="row">
        <div class="inner_container ">
            
            <div class="profile_tab_container">

                <div class="col-md-3 margin-top-30">
                    <div class="account-left">
                        <ul id="update_institution_tab" class="nav nav-pills nav-stacked">
                            <li class="active"><a data-toggle="tab" href="#lonin-setting">Login Setting</a></li>
                            <li class=""><a data-toggle="tab" href="#personal-detail">Personal Detail</a></li>
                            <li class=""><a data-toggle="tab" href="#change-profile-photo">Change profile photo</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-9 margin-top-30">
                    <div class="account-right"> 
                        
                            
                            <div id="change-profile-photo" class="tab-content fade in tabify margin-bottom-30">
                               
                                <?php
                                    $user_img_model = new User();
                                    echo FileInput::widget([
                                        'model' => $user_img_model,
                                        'attribute' => 'image',
                                        'options'=>[
                                            'multiple'=>false
                                        ],
                                        'pluginOptions' => [
                                            'uploadUrl' => Url::to(['/user/change_profile_photo']),
                                            'uploadExtraData' => [
                                                'id' => \Yii::$app->user->identity->id,
                                                'img_type'=>'profile',
                                                'instance'=>'image',
                                                'from'=>'inner'
                                            ],
                                            'allowedFileExtensions' => ['jpg', 'png'],
                                            'dropZoneEnabled' =>false,
                                            'showUpload' => false,
                                            'initialPreviewShowDelete' => false,
                                            'browseLabel' => 'Change Picture',
                                            'showRemove' => true,
                                            'showCancel' => false,
                                            'browseIcon'=>'',
                                            'browseClass'=>'btn btn-success'
                                        ],
                                        'pluginEvents' => [
                                            'fileimageloaded' => 'function(event, previewId){
                                                $("#user-image").fileinput("upload");
                                            }',
                                            'fileuploaded'=>'function(event, data, previewId, index){
                                                $(".profile_image_container img").attr("src",data.response.files.url);
                                                
                                            }',
                                            'filebatchuploadcomplete' => 'function(event, files, extra){
                                                $(".fileinput-remove-button").click();
                                            }',
                                        ]
                                    ]);
                                ?>

                            </div>

                            <div id="lonin-setting" class="tab-content fade in active tabify margin-bottom-30">
                                <h3>Your login setting here</h3>
                                
                                <div class="ac-login-setting-form">
                                    
									<?php
                                        $form = ActiveForm::begin(
                                            [      
                                                'action' => Url::base().'/site/changepassword',                  
                                                'options' => [
                                                    'class' => 'change_password'
                                                ]
                                            ]
                                        );
                                    ?>
                                    
                                   

                                        <label for="user-id">User Id (Fixed)</label>
                                        <input id="user-id" type="email" placeholder="<?= $model->email; ?>" disabled="">   
                                        <label for="new-pass">Old Password</label>
                                        <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => 255])->label(false); ?> 
                                        <label for="new-pass">Choose a new password</label>
                                        <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => 255])->label(false); ?> 
                                        <label for="retype-pass">Retype your password</label>
                                        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255])->label(false); ?> 
                                        
                                        <div class="profile_submit_form">
                                            <button type="submit" class="btn btn-primaryupdate_password ">Update</button>                           
                                            <div class="password_result"></div>
                                        </div>

                                    <?php ActiveForm::end(); ?>

                                </div>
                                
                            </div>
                            <div id="personal-detail" class="tab-content fade tabify margin-bottom-30">

                               
                                <h3>Edit your personal information</h3>
                                <div class="ac-login-setting-form">
                                    <?php
                                        $form = ActiveForm::begin(
                                            [   
                                                'action' => Url::base().'/site/info_edit',                                                                 
                                                'options' => [
                                                    'class' => 'update_my_profile_data'
                                                ]
                                            ]
                                        );
                                    ?>
                                    <div class="width100"> 
                                    	 <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                                    </div>

                                     <div class="width100">
                                        <?= $form->field($model, 'address')->textArea(['rows' => '7']) ?>
                                    </div>

                                    <div class="width100">
                                     	<?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>
                                    </div>
									
									<div class="width100">
										<?= $form->field($details_model, 'institution_name')->textInput(['maxlength' => 255]) ?>
										
									</div>

                                    <div class="profile_submit_form">
                                        <?= Html::submitButton(($model->isNewRecord)?'Create':'Update', ['class' => 'btn btn-primary']) ?>
                                        <div class="profile_data_result"></div>
                                    </div>
                                    <?php ActiveForm::end(); ?>

                                                           
                                </div>  
                            </div> 
                                                
                    </div>
                </div>
            </div>

            <div class="col-md-6 padding-right-0 margin-bottom-30">
                <div class="advertisement">
                    <img src="<?= Url::base('') ?>/images/ad.png">
                </div>
            </div>

            <div class="col-md-6 padding-right-0 margin-bottom-30">
                <div class="advertisement">
                    <img src="<?= Url::base('') ?>/images/ad.png">
                </div>
            </div>

        </div>
    </div>
</div>

<?php

     $this->registerJs("
    
        $(document).ready(
            $(document).delegate('.update_my_profile_data', 'beforeSubmit', function(event, jqXHR, settings) {
                
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
                                $('.profile_data_result').html(dt.message);
                                
                                setTimeout(function() {
                                    $('.profile_data_result').html('');
                                }, 4000);
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "update_my_profile_info");


    $this->registerJs("
        $(document).ready(
            
            $(document).delegate('.change_password', 'beforeSubmit', function(event, jqXHR, settings) {
                
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
                                $('.password_result').html(dt.message);
                                
                                setTimeout(function() {
                                    $('.password_result').html('');
                                }, 4000);
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "update_my_profile_password");
    
    $this->registerJs('
        var type = "#'.$_GET["type"].'";
        console.log(type); 
        $("#update_institution_tab a[href="+type+"]").tab("show"); 
        
    ', yii\web\View::POS_READY, 'active_tab_panel');
?>