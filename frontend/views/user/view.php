<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use kartik\file\FileInput;

	use frontend\models\NotificationList;
	use frontend\models\User;

	$this->title = "View Profile | Model Test";
?>
<div class="container ">
	<div class="row">
		<div class="inner_container ">
			
			<div class="profile_tab_container">

				<div class="col-md-3 margin-top-30">
					<div class="account-left">

						<ul class="nav nav-pills nav-stacked">
						    <li class="<?php if(isset($_GET['tab']) && $_GET['tab'] =='personal_details' ){echo 'active';} ?>"><a data-toggle="tab" href="#personal-detail">Personal Detail</a></li>
						    <li class=""><a data-toggle="tab" href="#lonin-setting">Login Setting</a></li>						    
						    <!-- <li class=""><a data-toggle="tab" href="#sharing">Sharing Preferences</a></li> -->
						    <li class="<?php if(isset($_GET['tab']) && $_GET['tab'] =='points_payments' ){echo 'active';} ?>"><a data-toggle="tab" href="#point-payment">Points &amp; Payment Status</a></li>
						    <li class=""><a data-toggle="tab" href="#invite_my_friend">Invite My friends</a></li>
					  	</ul>
					</div>
				</div>

				<div class="col-md-9 margin-top-30">
					<div class="account-right editprofilephoto">	
							
						    <div id="lonin-setting" class="tab-content fade tabify margin-bottom-30">
						      	<h3>Login Setting</h3>
						      	
						      		<div class="ac-login-setting-form">
						      			<div class="width100">
								      		<label for="user-id">User Id (Fixed)</label>
								      		<?= $model->email; ?>
								      	</div>
								      	<div class="width100">
								      		<label for="new-pass">Password</label>
								      		*********	
							      		</div>	

							      		<div class="profile_submit_form">
	                                        <a href="<?= Url::toRoute(['user/edit?type=changepassword']);?>">Change Password</a>
	                                    </div>				      		
							      	</div>
						      	
						    </div>
						    <div id="personal-detail" class="tab-content fade <?php if(isset($_GET['tab']) && $_GET['tab'] =='personal_details' ){echo 'active in';} ?> tabify margin-bottom-30">
						      <h3>Personal Detail</h3>
						        <div class="ac-login-setting-form">

						        	<div class="personal_data_container">
							      		<div class="width100 personal_details_view">
								      		<label for="user-id">Full Name</label>
								      		<span><?= $model->name; ?></span>
								      	</div>

								      	<?php if(!empty($model->address)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Address</label>
									      		<span><?= $model->address; ?></span>
									      	</div>
								        <?php endif; ?>

								      	<?php if(!empty($details_model->date_of_birth)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Date of birth</label>
									      		<span><?= date_format(date_create($details_model->date_of_birth), 'dS F Y') ?></span>
									      	</div>
								        <?php endif; ?>

								        <?php if(!empty($details_model->gender)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Gender</label>
									      		<span><?= $details_model->gender; ?></span>
									      	</div>
								        <?php endif; ?>

								      	<?php if(!empty($model->phone)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Mobile Number</label>
									      		<span><?= $model->phone; ?></span>
									      	</div>
								        <?php endif; ?>

								        <?php if(!empty($details_model->education)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Education Level (last)</label>
									      		<span><?= $details_model->education; ?></span>
									      	</div>
								        <?php endif;?>

								      	<?php if(!empty($details_model->institution_name)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Educational Institute</label>
									      		<span><?= $details_model->institution_name; ?></span>
									      	</div>
								        <?php endif; ?>

								        <?php if(!empty($details_model->employee_status)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Employment Status</label>
									      		<span><?= $details_model->employee_status; ?></span>
									      	</div>
								        <?php endif;?>

								        <?php if(!empty($details_model->employee_organization)):?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Organization</label>
									      		<span><?= $details_model->employee_organization; ?></span>
									      	</div>
									    <?php endif; ?>

									    <?php if($model->approved_by_institution == 1):?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Do you join any institution?</label>
									      		<span><?= $model->institutionname->name; ?></span>
									      	</div>
									    <?php endif; ?>

									    <?php if(!empty($details_model->how_do_you_know_about_modeltest)):?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">How do you know about model-test.com?</label>
									      		<span><?= $details_model->how_do_you_know_about_modeltest; ?></span>
									      	</div>
								        <?php endif;?>

								        <?php if(!empty($details_model->your_expectation)):?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">What is your main expectation from model-test.com?</label>
									      		<span><?= $details_model->your_expectation; ?></span>
									      	</div>
								        <?php endif;?>

								        <?php if(!empty($details_model->recommended_other)): ?>
									      	<div class="width100 personal_details_view">
									      		<label for="user-id">Will you recommend model-test.com to others, if you find it helpful?</label>
									      		<span><?= $details_model->recommended_other; ?></span>
									      	</div>
								      	<?php endif;?>

								      	<div class="profile_submit_form">
	                                        <a href="<?= Url::toRoute(['user/edit?type=personal-detail']);?>">Edit</a>
	                                    </div>
									</div>


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
		                                    // $user_img_model = new User();
		                                    // echo FileInput::widget([
		                                    //     'model' => $user_img_model,
		                                    //     'attribute' => 'image',
		                                    //     'options'=>[
		                                    //         'multiple'=>false
		                                    //     ],
		                                    //     'pluginOptions' => [
		                                    //         'uploadUrl' => Url::to(['/user/change_profile_photo']),
		                                    //         'uploadExtraData' => [
		                                    //             'id' => \Yii::$app->user->identity->id,
		                                    //             'img_type'=>'profile',
		                                    //             'instance'=>'image',
		                                    //             'from'=>'inner'
		                                    //         ],
		                                    //         'allowedFileExtensions' => ['jpg', 'png'],
		                                    //         'dropZoneEnabled' =>false,
		                                    //         'showUpload' => false,
		                                    //         'initialPreviewShowDelete' => false,
		                                    //         'browseLabel' => 'Change',
		                                    //         'showRemove' => true,
		                                    //         'showCancel' => false,
		                                    //         'browseIcon'=>'',
		                                    //         'browseClass'=>'btn btn-success'
		                                    //     ],
		                                    //     'pluginEvents' => [
		                                    //         'fileimageloaded' => 'function(event, previewId){
		                                    //             $("#user-image").fileinput("upload");
		                                    //         }',
		                                    //         'fileuploaded'=>'function(event, data, previewId, index){
		                                    //             $(".profile_picture_container img").attr("src",data.response.files.url);
		                                                
		                                    //         }',
		                                    //         'filebatchuploadcomplete' => 'function(event, files, extra){
		                                    //             $(".fileinput-remove-button").click();
		                                    //         }',
		                                    //     ]
		                                    // ]);
		                                ?>
										
										
		
									</div>

						      	</div>	
						    </div>	


						    <div id="sharing" class="tab-content fade tabify margin-bottom-30">
						      	<h3>Email notification</h3>
						      	<p>Send me an email, when:</p>

						      	<?php
						      		if(isset($get_all_notification_r)){
						      			foreach($get_all_notification_r as $get_all_notification){
						      				$notification_q = NotificationList::find()
						      									->where(['id' => $get_all_notification->notification_id])
						      									->one();

						      	?>
											<div class="checkbox-container">
									      		<input checked id="assign-exam" type="checkbox">
										      	<label for="assign-exam"><?= $notification_q->desc ?>
										      	</label>
										    </div>
						      	<?php
						      			}
						      		}
						      	?>
						      	
						      		

						      		<div class="checkbox-container">

							      		<!-- <h4>Invite my friends</h4>							      		 -->
							      		<div class="invite">
							      			<div class="list_of_invite_friends">
								      			<?php
								      				if(isset($my_invite_friends_r)){
								      					foreach($my_invite_friends_r as $my_invite_friends){
								      						//echo $my_invite_friends->invite_friends_email . ' , ';
								      					}
								      				}
								      			?>
								      		</div>
							      			<!-- <input type="text" placeholder="Friend's Email address">
							      			<a class="email-send-btn" href="#">Send</a> -->
							      		</div>
							      		
							      	</div>

							      	<div class="profile_submit_form">
                                        <a href="<?= Url::toRoute(['user/edit?type=sharing']);?>">Edit</a>
                                    </div>
						    </div>


						    <div id="point-payment" class="tab-content fade <?php if(isset($_GET['tab']) && $_GET['tab'] =='points_payments' ){echo 'active in';} ?> tabify margin-bottom-30">					    	
						    	
						    	<div class="accounts_cont_area">					    	
							    	<div class="ac_point account_ac_point account_heading">
								    	<h3>Points status</h3>
								    	<div class="pointpayment_rightbar">
									    	<span>Your total points: <span class="points_style"><?= $sum_of_points+Yii::$app->user->identity->free_point; ?></span></span>
									    </div>
							    	</div>
							    	<div class="ac_point account_ac_point">
								    	<h3>Redeemed Points</h3>			    	
							    	</div>		
							    	<div class="points_history_table col-md-12">
							    		<div class="row">			    	
									      	<table class="table table-striped table-bordered  accounts_point_table">
												<tbody>
													<tr>
													    
													    <th class="ac_table_data" style="width:300px;">Date &amp; time</th>
													    <th class="ac_table_data">Package</th>
													    <th class="ac_table_data">Opening</th>
													    <th class="ac_table_data">Points</th>								    
													    <th class="ac_table_data">Action Name</th>
													    <th class="ac_table_data">Balance points</th>
													</tr>
													<?php
														$count = 1;
														if(!empty($transaction_history)){
															foreach ($transaction_history as $transaction) {
													?>

														<tr>
														    
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
						    			<div class="row margin-bottom-50">
						    				<?php

						    					if(count($transaction_history) > 9):
						    				?>
						    					<a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" data-action="-" class="btn btn-sm btn-primary load_more_transaction">Load more</a>
						    				<?php
						    					endif;
						    				?>
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
						    			<div class="row margin-bottom-50">
						    				<?php
						    					if(count($transaction_history_added) > 9): 
						    				?>
						    					<a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" data-action="+" class="btn btn-sm btn-primary load_more_transaction_add floatright">Load more</a>
						    				<?php
						    					endif;
						    				?>
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
									    	<span><a class="membership-payment-guideline" href="<?= Url::toRoute(['page/how-to-pay']) ?>"><span style="float:left;" class="payment_guideline_icon">!</span>&nbsp; Payments guideline</a></span>
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
						    			<div class="row margin-bottom-50">
						    				<?php
						    					if(count($PurchaseHistroy) > 9):
						    				?>
						    					<a href="<?= Url::toRoute(['user/load_more_data']); ?>" data-offset="10" class="btn btn-sm btn-primary load_more_payment">Load more</a>
						    				<?php
						    					endif;
						    				?>
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
                                                
                                                <div class="load_more_loader">
		                                            <div class="css_loader_container_wrap">
		                                                <div class="css_loader_container" style="left:65%;top:35%;">
		                                                    <div class="cssload-loader"></div>
		                                                </div>
		                                            </div>
		                                        </div>
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

		</div>
	</div>
</div>

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

	", yii\web\View::POS_READY, "load_more_view_section");

	$this->registerJs("
        
            $(document).ready(
                $(document).delegate('.invite_friends', 'beforeSubmit', function(event, jqXHR, settings) {
                    
                        var form = $(this);
                        if(form.find('.has-error').length) {
                                return false;
                        }
                        
                        $('.css_loader_container_wrap').fadeIn();
                        $.ajax({
                                url: form.attr('action'),
                                type: 'post',
                                data: form.serialize(),
                                success: function(data) {

                                	$('.css_loader_container_wrap').fadeOut();
                                	
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

?>