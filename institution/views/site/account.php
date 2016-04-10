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
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a data-toggle="tab" href="#personal-detail">Personal Detail</a></li>
                            <li class=""><a data-toggle="tab" href="#lonin-setting">Login Setting</a></li>
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
                                            'uploadUrl' => Url::to(['/site/change_profile_photo']),
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

                            <div id="lonin-setting" class="tab-content fade tabify margin-bottom-30">
                                <h3>Your login setting here</h3>
                                
                                <div class="ac-login-setting-form">
                                    
									<div class="width100">
                                        <label for="user-id">User Id (Fixed)</label>
                                        <?= $model->email; ?>
                                    </div>

                                    <div class="width100">
                                        <label for="user-id">Password</label>
                                        *****
                                    </div>
                                    
                                    <div class="profile_submit_form">
                                        <a href="<?= Url::toRoute(['site/edit?type=changepassword']);?>">Change Password</a>
                                    </div>

                                </div>
                                
                            </div>
                            <div id="personal-detail" class="tab-content fade in active tabify margin-bottom-30">

                               
                                <h3>Your personal information</h3>
                                <div class="ac-login-setting-form">
                                    <div class="width100 logindiv"> 
                                    	<label>Name</label>
                                        <?= $model->name; ?>
                                    </div>

                                     <div class="width100 logindiv">
                                        <label>Address</label>
                                        <?= $model->address; ?>
                                    </div>

                                     <div class="width100 logindiv">
                                     	<label>Email</label>
                                        <?= $model->email;?>
                                    </div>

                                    <div class="width100 logindiv">
                                     	<label>Phone</label>
                                        <?= $model->phone;?>
                                    </div>
									
									<div class="width100 logindiv">
										<label>Institution</label>
										<?= $details_model->institution_name; ?>
									</div>

                                    <div class="profile_submit_form">
                                        <a href="<?= Url::toRoute(['site/edit?type=personal-detail']);?>">Edit</a>
                                    </div>

                                                           
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
