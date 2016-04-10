<?php
	use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use kartik\file\FileInput;
    use kartik\select2\Select2;

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
                        <ul class="nav nav-pills nav-stacked" id="update_student_tab">
                            <li class="active"><a data-toggle="tab" href="#personal-detail">Personal Detail</a></li>
                            <li class=""><a data-toggle="tab" href="#changepassword">Login Setting</a></li>
                            <!-- <li class=""><a data-toggle="tab" href="#sharing">Sharing Preferences</a></li> -->
                            <li class=""><a data-toggle="tab" href="#point-payment">Points &amp; Payment Status</a></li>
                            <li class=""><a data-toggle="tab" href="#invite_my_friend">Invite My friends</a></li>
                            
                        </ul>
                    </div>
                </div>

                <div class="col-md-9 margin-top-30">
                    <div class="account-right editprofilephoto"> 
                        
                           
                            <div id="changepassword" class="tab-content fade tabify margin-bottom-30">
                                <h3>Edit your login setting here</h3>
                                
                                <div class="ac-login-setting-form">
                                    
                                    <?php
                                        $form = ActiveForm::begin(
                                            [      
                                                'action' => Url::base().'/user/changepassword',                  
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
                            <div id="personal-detail" class="tab-content fade in active tabify margin-bottom-30">

                                
                                <?php
                                    $form = ActiveForm::begin(
                                        [   
                                            'action' => Url::base().'/user/info_edit',                                                                 
                                            'options' => [
                                                'class' => 'update_my_profile_data'
                                            ]
                                        ]
                                    );
                                ?>

                                <h3>Edit your personal information</h3>
                                <div class="ac-login-setting-form">

                                    <div class="personal_data_container">
                                        <div class="width100"> 
                                            <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?> 
                                        </div>
                                        
                                        <div class="width100">
                                            <?= $model->isNewRecord?$form->field($model, 'username')->textInput(['maxlength' => 255]):'' ?>
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($model, 'address')->textArea(['rows' => '4']) ?>
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'date_of_birth')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <?php
                                            $data_gender = array ('Male'=>'Male',
                                                                    'Female'=>'Female'
                                                            );
                                            echo $form->field($details_model, 'gender')
                                                    ->dropDownList(
                                                        $data_gender,           
                                                        ['prompt'=>'Select Gender','class'=>'form-control gender']    // options
                                                    );
                                        ?>

                                        <div class="width100">
                                            <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'education')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'institution_name')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'employee_status')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'employee_organization')->textInput(['maxlength' => 255]) ?>    
                                        </div>

                                        <div class="width100">
                                             <?php
                                                echo $form->field($model, 'institution_id')->widget(Select2::classname(), [
                                                    'data' => User::get_all_institution_list(),
                                                    'options' => ['placeholder' => 'Select a institution ...','multiple'=>false],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);    
                                            ?>
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'how_do_you_know_about_modeltest')->textArea(['rows' => '4']) ?>
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'your_expectation')->textArea(['rows' => '4']) ?>
                                        </div>

                                        <div class="width100">
                                            <?= $form->field($details_model, 'recommended_other')->textArea(['rows' => '4']) ?>
                                        </div>

                                         <div class="width100">
                                            <?= $form->field($model, 'email')->hiddenInput(['maxlength' => 255])->label(false); ?>
                                        </div>

                                         <div class="width100">
                                            <?= $model->isNewRecord?$form->field($model, 'password')->passwordInput(['maxlength' => 255]):''; ?>
                                        </div>

                                        <div class="width100">
                                            <?php if($model->isNewRecord): ?>
                                                <?= $form->field($model, 'image')->fileInput() ?>
                                            <?php endif; ?>
                                        </div>

                                         <div class="profile_submit_form">
                                            <?= Html::submitButton(($model->isNewRecord)?'Create':'Update', ['class' => 'btn btn-primary']) ?>
                                            <div class="profile_data_result"></div>
                                        </div>

                                    </div>
                                    <?php ActiveForm::end(); ?>


                                    <div class="profile_photo_container">
                                        
                                        <div class="profile_picture_container">
                                            <?php
                                                if(!empty($model->image)){
                                            ?>
                                                <img src="<?= Url::base('') ?>/user_img/<?= $model->image ?>">
                                            <?php  }else{ ?>
                                                <img src="<?= Url::base('') ?>/images/profile_avater.jpg">
                                            <?php  }  ?>    
                                        </div>

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
                                                    'browseLabel' => 'Change',
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
                                    
                                                           
                                </div>  
                            </div>  
                            <div id="sharing" class="tab-content fade tabify margin-bottom-30">
                                <h3>Email notification</h3>
                                <p>Send me an email, when:</p>

                                    <?php
                                        $form = ActiveForm::begin(
                                            [      
                                                'action' => Url::base().'/user/set_shareing',                  
                                                'options' => [
                                                    'class' => 'set_shareing'
                                                ]
                                            ]
                                        );
                                    ?>
                   
                                   
                                            <?php
                                                if(isset($notification_list)){
                                                    foreach($notification_list as $notification){
                                                        $my_notification_list = UserNotificationRel::find()
                                                                                ->where(['user_id'=>$model->id])
                                                                                ->andWhere(['notification_id' => $notification->id ])
                                                                                ->one();
                                            ?>
                                                        <div class="checkbox-container">
                                                            <input <?php if(isset($my_notification_list)){ echo 'checked'; } ?> id="assign-exam" type="checkbox" name="NotificationList[name][]" value="<?= $notification->id?>">
                                                            <label for="assign-exam"><?= $notification->desc ?></label>
                                                        </div>
                                            <?php
                                                    }
                                                }                                        
                                            ?>


                                   

                                        <div class="profile_submit_form">
                                            <?= Html::submitButton(($model->isNewRecord)?'Create':'Update', ['class' => 'btn btn-primary']) ?>
                                            <div class="profile_data_result"></div>
                                        </div>


                                <?php ActiveForm::end(); ?>

                            </div>

                            <div id="point-payment" class="tab-content fade tabify margin-bottom-30">                           
                                
                                <div class="accounts_cont_area">                            
                                    <div class="ac_point account_ac_point">
                                        <h3>Points status</h3>
                                        <div class="pointpayment_rightbar">
                                            <span>Your total points: <?= $sum_of_points+Yii::$app->user->identity->free_point; ?></span>
                                        </div>
                                    </div>
                                    <div class="ac_point account_ac_point">
                                        <h3>Lost Points</h3>                    
                                    </div>      
                                    <div class="points_history_table col-md-12">
                                        <div class="row">                   
                                            <table class="table table-striped table-bordered  accounts_point_table">
                                                <tbody>
                                                    <tr>
                                                        <th class="ac_table_data">#</th>
                                                        <th class="ac_table_data" style="width:300px;">Date &amp; time</th>
                                                        <th class="ac_table_data">Package</th>
                                                        <th class="ac_table_data">Opening</th>
                                                        <th class="ac_table_data">Points</th>                                   
                                                        <th class="ac_table_data">Action Name</th>
                                                        <th class="ac_table_data">Balance points</th>
                                                    </tr>
                                                    <?php

                                                        if(!empty($transaction_history)){
                                                            foreach ($transaction_history as $transaction) {
                                                    ?>

                                                        <tr>
                                                            <td class="ac_table_data"><?= $transaction->id; ?></td>
                                                            <td class="ac_table_data"><?= date_format(date_create($transaction->time), 'jS F\, Y h:i A'); ?></td>
                                                            <td class="ac_table_data">
                                                                <?php
                                                                    if($transaction->purchased_package_id == 0){
                                                                        echo 'Free Point';
                                                                    }else{
                                                                        echo $transaction->package_name->package_name;
                                                                    }
                                                                ?>
                                                            </td>
                                                            
                                                            <td class="ac_table_data"><?= $transaction->opening; ?></td>
                                                            <td class="ac_table_data"><?= $transaction->points; ?></td>                                     
                                                            <td class="ac_table_data"><?= $transaction->type; ?></td>
                                                            <td class="ac_table_data"><?= $transaction->closing; ?></td>
                                                        </tr>

                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" data-action="-" class="btn btn-sm btn-primary load_more_transaction">Load more</a>
                                        </div>
                                        <div class="load_more_loader">
                                            <div class="css_loader_container_wrap">
                                                <div class="css_loader_container">
                                                    <div class="cssload-loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ac_point account_ac_point">
                                        <h3>Added Points</h3>                   
                                    </div>      
                                    <div class="points_history_table col-md-12">
                                        <div class="row">                   
                                            <table class="table table-striped table-bordered  accounts_point_table_add">
                                                <tbody>
                                                    <tr>
                                                        <th class="ac_table_data">#</th>
                                                        <th class="ac_table_data" style="width:300px;">Date &amp; time</th>
                                                        <th class="ac_table_data">Package</th>
                                                        <th class="ac_table_data">Opening</th>
                                                        <th class="ac_table_data">Points</th>                                   
                                                        <th class="ac_table_data">Action Name</th>
                                                        <th class="ac_table_data">Balance points</th>
                                                    </tr>
                                                    <?php

                                                        if(!empty($transaction_history_added)){
                                                            foreach ($transaction_history_added as $transaction) {
                                                    ?>

                                                        <tr>
                                                            <td class="ac_table_data"><?= $transaction->id; ?></td>
                                                            <td class="ac_table_data"><?= date_format(date_create($transaction->time), 'jS F\, Y h:i A'); ?></td>
                                                            <td class="ac_table_data">
                                                                <?php
                                                                    if($transaction->purchased_package_id == 0){
                                                                        echo 'Free Point';
                                                                    }else{
                                                                        echo $transaction->package_name->package_name;
                                                                    }
                                                                ?>
                                                            </td>
                                                            
                                                            <td class="ac_table_data"><?= $transaction->opening; ?></td>
                                                            <td class="ac_table_data"><?= $transaction->points; ?></td>                                     
                                                            <td class="ac_table_data"><?= $transaction->type; ?></td>
                                                            <td class="ac_table_data"><?= $transaction->closing; ?></td>
                                                        </tr>

                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="row">
                                            <a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" data-action="+" class="btn btn-sm btn-primary load_more_transaction_add floatright">Load more</a>
                                        </div>
                                        <div class="load_more_loader">
                                            <div class="css_loader_container_wrap">
                                                <div class="css_loader_container">
                                                    <div class="cssload-loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="ac_point account_ac_point payment_status_cont_area">
                                        <h3>Payment status</h3>
                                        <div class="pointpayment_rightbar">
                                            <span>Payments guideline ?</span>
                                        </div>
                                    </div>      
                                    <div class="points_history_table col-md-12">
                                        <div class="row">                   
                                            <table class="table table-striped table-bordered  accounts_payment_table">
                                                <tbody>
                                                    <tr>
                                                        <th class="ac_table_data">Ref. no</th>
                                                        <th class="ac_table_data" style="width:300px;">Date &amp; time</th>
                                                        <th class="ac_table_data">Method</th>
                                                        <th class="ac_table_data">Amount</th>
                                                        <th class="ac_table_data">Balance expired</th>
                                                    </tr>
                                                    <?php

                                                        if(!empty($PurchaseHistroy)){
                                                            foreach ($PurchaseHistroy as $purchase) {
                                                    ?>

                                                        <tr>
                                                            <td class="ac_table_data"><?= $purchase->payment_id; ?></td>
                                                            <td class="ac_table_data"><?= date_format(date_create($purchase->time), 'jS F\, Y h:i A'); ?></td>
                                                            <td class="ac_table_data">
                                                                <?php
                                                                    echo $purchase->payment_type;
                                                                ?>
                                                            </td>
                                                            
                                                            <td class="ac_table_data"><?= $purchase->price; ?></td>
                                                            <td class="ac_table_data"><?= $purchase->end_date; ?></td>
                                                        </tr>

                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" class="btn btn-sm btn-primary load_more_payment">Load more</a>
                                        </div>
                                        <div class="load_more_loader">
                                            <div class="css_loader_container_wrap">
                                                <div class="css_loader_container">
                                                    <div class="cssload-loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>                           
                                
                            </div>

                            <div id="invite_my_friend" class="tab-content fade tabify margin-bottom-30">
                                
                                 <div class="checkbox-container">
                                    
                                    <?php
                                        $form = ActiveForm::begin(
                                            [      
                                                'action' => Url::base().'/user/invite_friends',                  
                                                'options' => [
                                                    'class' => 'invite_friends'
                                                ]
                                            ]
                                        );
                                    ?>

                                            <h4>Invite my friends</h4>                                      
                                            <div class="invite">
                                                <input type="email" name="InviteFriends[invite_friends]" placeholder="Email-address">                                            
                                                <?= Html::submitButton(($model->isNewRecord)?'Create':'Send', ['class' => 'btn btn-primary']) ?>
                                                <div class="profile_data_result"></div>
                                            </div>

                                            
                                            <!-- <div class="add_more_invite_friends">
                                                +
                                            </div> -->

                                          

                                    <?php ActiveForm::end(); ?>

                                    <div class="invite_friend_container">
                                        <?php

                                            if(isset($get_all_invite_friends_r)){
                                        ?>

                                            <table class="table table-striped table-bordered  accounts_point_table margin-top-30">
                                                <tr>
                                                    <td>Email Address</td>
                                                    <td>Status</td>
                                                </tr>

                                        <?php
                                                foreach($get_all_invite_friends_r as $get_all_invite_friends){
                                        ?>
                                                
                                                    <tr>
                                                        <td><?= $get_all_invite_friends->invite_friends_email; ?></td>
                                                        <td>
                                                            <?php
                                                                if($get_all_invite_friends->status == 1){
                                                                    echo 'Accept';
                                                                }else{
                                                                    echo 'Not Accept';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                
                                        <?php
                                                }
                                        ?>
                                                </table>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    
                                </div>

                            </div>

                                                
                    </div>
                </div>
            </div>

            <div class="col-md-6 margin-bottom-30">
                <div class="advertisement">
                    <img src="<?= Url::base('') ?>/images/ad.png">
                </div>
            </div>

            <div class="col-md-6 margin-bottom-30">
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

                                    if(dt.success == 1){
                                        window.location.href=dt.base_url+'/user/view?tab=personal_details';     
                                    }
                                    
                                }, 4000);
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "update_my_profile_password");


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

                                    if(dt.success == 1){
                                        window.location.href=dt.base_url+'/user/view?tab=personal_details';     
                                    }
                                    
                                }, 4000);
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "update_my_profile_info");

    $this->registerJs("
        
            $(document).ready(
                $(document).delegate('.set_shareing', 'beforeSubmit', function(event, jqXHR, settings) {
                    
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
        
        ", yii\web\View::POS_READY, "update_my_shareing_data");

$this->registerJs("
        
            $(document).ready(
                $(document).delegate('.invite_friends', 'beforeSubmit', function(event, jqXHR, settings) {
                    
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
                                    $('.invite_friend_container table').append(dt.successmsg);
                                    setTimeout(function() {
                                        $('.profile_data_result ').html('');
                                    }, 4000);
                                }
                        });
                        
                        return false;
                })


            );
        
        ", yii\web\View::POS_READY, "invite_friends");
    
    $this->registerJs('
        
                $( ".add_more_invite_friends" ).click(function() {
                    
                    var type = "email";
                    var name = "InviteFriends[invite_friends][]";
                    var placeholder = "Email-address";
                    var class_add = "remove_invite_friends";
                   
                    $(".invite").append("<input type="+type+" name="+name+" placeholder="+placeholder+" class="+class_add+">");
                    return false;
                });
                
                // $("#myTabs a[href=#personal-detail]").tab("show"); 
                
                              
        
        ', yii\web\View::POS_READY, 'add_more_invite_friends');

    $this->registerJs('
        var type = "#'.$_GET["type"].'";
        console.log(type); 
        $("#update_student_tab a[href="+type+"]").tab("show"); 
        
    ', yii\web\View::POS_READY, 'active_tab_panel');
?>

<?php
    $this->registerJs("

        $('.load_more_transaction_add').on('click',function (e) {
            var offset = $(this).attr('data-offset');
            var data_action = $(this).attr('data-action');
            var url = $(this).attr('href');
            
            get_more_data('transaction',url,offset,'.load_more_transaction_add','.accounts_point_table_add tbody',data_action);

            return false;
        });
        
        $('.load_more_transaction').on('click',function (e) {
            var offset = $(this).attr('data-offset');
            var data_action = $(this).attr('data-action');
            var url = $(this).attr('href');
            
            get_more_data('transaction',url,offset,'.load_more_transaction','.accounts_point_table tbody',data_action);

            return false;
        });

        $('.load_more_payment').on('click',function (e) {
            var offset = $(this).attr('data-offset');
            var url = $(this).attr('href');
            var data_action = '';
            
            get_more_data('purchase_history',url,offset,'.load_more_payment','.accounts_payment_table tbody',data_action);

            return false;
        });

        function get_more_data(type,url,offset,class_name,table_name,data_action){
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : url,
                data: {type:type,offset:offset,data_action:data_action},
                beforeSend : function( request ){
                    $(class_name).parent().next().find('.css_loader_container_wrap').fadeIn();
                },
                success : function( data )
                    { 
                    $(class_name).parent().next().find('.css_loader_container_wrap').fadeOut();

                        if(data.result == 'success'){
                            var new_offset = parseInt(offset)+10;
                            $(class_name).attr('data-offset',new_offset);
                            $(table_name).append(data.msg);
                            if(data.item_count == '0'){
                                $(class_name).hide();
                            }
                        }
                        else if(data.result == 'error'){
                            //window.location = data.redirect_url;
                        }
                    }
            });
        }

    ", yii\web\View::POS_READY, "load_more_update_section");

    $this->registerJs("
        
        
        jQuery('#userdetails-date_of_birth').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '-16425d',
            endDate: '-3652d'
        });



    ", yii\web\View::POS_READY, "date_of_birth_datepicker");


    $this->registerJs("

        $.mask.definitions['~']='[(0)]';
        $('#user-phone').mask('(+88)-~999-9999-999');

    ", yii\web\View::POS_READY, 'mobile_number_validation'); 

?>