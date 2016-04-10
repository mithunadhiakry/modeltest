<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->title = "Membership | Model Test";
?>
<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="inner_common_page margin-top-30">
				<h3>Membership & Payments Plan
					<a class="marginbottom20 floatright membership-payment-guideline" href="<?= Url::toRoute(['page/how-to-pay']);?>"><span class="payment_guideline_icon">!</span> Payments guideline</a>
				</h3>
				
				<div class="margin-top-30">

					<table class="table activity-log-report membership-payment">
						
							<?php
								foreach ($columns as $key) {
									if($key =='id' || $key == 'time'){

									}else{
										
							?>
									<tr>
											<td><?= Html::activeLabel($package_model,$key); ?></td>
											<?php
											
												if(isset($membership_data_r)){
													foreach($membership_data_r as $membership_data){

											?>	
																	
													<td>
														<?php 
															if($key == 'duration'){
																echo ($membership_data->$key / 30) .' Months';
															}else if($key == 'price_bd'){

																if($membership_data->$key == 0){
																	echo $membership_data->$key;
																}else{
																	echo $membership_data->$key . ' / Months';
																}
																
															}else{
																echo $membership_data->$key;
															}
															
														?>
													</td>
												
											<?php

													}
											
												}
											?>
									</tr>

							<?php								
									}
								}

							?>

							<tr>
								<td>&nbsp;</td>
							<?php		
								if(isset($membership_data_r)){
									foreach($membership_data_r as $membership_data){
										
										if($membership_data->package_type != 'Free *' && $membership_data->package_type !='free *' && $membership_data->package_type != 'FREE *'){

											if(isset(\Yii::$app->user->identity)){
							?>

												<td><br/><a class="buy_now_button" href="<?= Url::toRoute(['user/confirm_purchase','id'=>$membership_data->id]);?>">Buy Now</a></td>
							<?php
											}else{ ?>


													<td><br/><a class="buy_now_button membership_buynow_alert" href="">Buy Now</a></td>
							<?php

											}

							?>	
												
											

							<?php
										}else{

							?>
											<td>&nbsp;</td>

							<?php
										}

									}
							
								}
							?>
							</tr>

						
					</table>


					<div class="membership-bottom-section">
						* Free Pack Based On Points Stock, Check The <a href="<?= Url::to(['page/points-rewards']); ?>">Point & Rewards</a> Page
					</div>
					

				</div>
			</div>
		</div>
	</div>
</div>

<?php

	if(!isset(\Yii::$app->user->identity)){


        $this->registerJs("

          	$('.membership_buynow_alert').on('click',function(){

          		var baseurl = $('#baseurl').attr('href'); 

          		BootstrapDialog.confirm({
                    title: 'WARNING',
                    message: 'You need to Sign in first to buy a package',
                    type: BootstrapDialog.TYPE_WARNING,
                    closable: false,
                    draggable: true,
                    btnCancelLabel: 'No!',
                    btnOKLabel: 'Yes!',
                    callback: function(result) {
                        if(result) {
                        	window.location = baseurl+'site/login';
                        }else {
                            return false;
                        }
                    }
                });

        return false;

          	});
          	

              

            
            
        ", yii\web\View::POS_READY, "membsership_registation");
}
    ?>