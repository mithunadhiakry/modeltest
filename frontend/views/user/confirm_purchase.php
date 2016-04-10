<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	$this->title = "Confirm Purchase | Model Test";
?>

<div class="container">
	<div class="row">
		<div class="inner_container">


			<div class="invoice_section">

				<div class="invoice_header margin-top-30">
					PURCHASE PREVIEW
				</div>
				<div class="invoice_details">
					<div class="col-md-5 margin-top-30">
						<div class="row">
							<div class="invoice-container">
								<div class="label">
									Invoice No
								</div>
								<div class="invoice-no">
									: 
									<?php
										echo 'Invoice-'.time();
									?>
								</div>
							</div>
							<div class="invoice-container">
								<div class="label">
									Date
								</div>
								<div class="invoice-no">
									: <?php echo Date('Y-m-d'); ?>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-7 margin-top-30">

						<div class="row">

							<div class="invoice-container">
								<div class="label">
									Customer Name
								</div>
								<div class="invoice-no">
									: 
									<?php
										echo $model->name;
									?>
								</div>
							</div>							

							<div class="invoice-container">
								<div class="label">
									Print Date
								</div>
								<div class="invoice-no">
									: <?php echo Date('Y-m-d'); ?>
								</div>
							</div>

						</div>

					</div>


				</div>

				<table class="table membership-payment margin-top-30 width100 text-align-center">
					
						<tr>
							<td>Points</td>
							<td>Duration</td>
							<td>Share Exam</td>
							<td>Save Exam</td>
							<td>Advanced Reporting</td>
							<td>Price</td>
						</tr>
					
						<tr>
							<td><?= $package->package_type; ?></td>
							<td>
								<?php
									echo ($package->duration/30) . ' month';
								?>
							</td>
							<td><?= $package->share_exam; ?></td>
							<td><?= $package->save_exam; ?></td>
							<td><?= $package->advanced_reporting; ?></td>
							<td>
								<?php
									echo $package->price_bd * $package->duration/30 .' tk';
									$total_sum_price = $package->price_bd * $package->duration/30;
								?>
							</td>
						</tr>

						

						<tr>
							<td colspan="6" class="text-align-right">

								<div class="discount-code-container">
									<div class="discount_code_form">
										<?php
	                                        $form = ActiveForm::begin(
	                                            [      
	                                                'action' => Url::base().'/user/discountsverification',                  
	                                                'options' => [
	                                                    'class' => 'discount_verfication'
	                                                ]
	                                            ]
	                                        );

	                                        $vat_amount = Yii::$app->params['vat'];
											$vat_value = ($vat_amount * $package->price_bd)/100;
	                                    ?>
											<?= $discounts_model->isNewRecord?$form->field($discounts_model, 'discounts_code')->textInput(['maxlength' => 255]):'' ?>
											<input type="hidden" name="total_amount" value="<?= $total_sum_price; ?>">
											<input type="hidden" name="vat_amount" value="<?= $vat_amount; ?>" >
											<?= Html::submitButton(($discounts_model->isNewRecord)?'Apply':'Update', ['class' => 'btn btn-primary']) ?>
										<?php ActiveForm::end(); ?>
										<p class="invalid_discount_code"></p>
									</div>
									<div class="discount_code_form get_calculate_discount">
										
										<div class="discounts_amounts"><span class="label">Discounts :</span> 0 tk</div>
										<div class="total_amount"><span class="label">Sub Total :</span> <?= $total_sum_price . ' tk'; ?></div>
										<div class="vat_amount"><span class="label">Vat( excluded ) :</span> <?= $vat_value .' tk'; ?></div>
										<div class="total_amount"><span class="label">Total Amount :</span> <?= $total_sum_price + $vat_value .'tk'; ?></div>
										
									</div>
								</div>
								
							</td>
						</tr>
					
				</table>

					<?php
                        $form = ActiveForm::begin(
                            [      
                                'action' => Url::base().'/user/paymentsuccess',  
                            ]
                        );
                    ?>

							<div class="payment_method_container">
								<div class="header red_color">
									Choose your payment options
								</div>

								<div class="payment_option_checkbox">
									<input type="radio" name="payment_method" value="bank">
									<label>Bank</label>
								</div>

								<div class="payment_option_checkbox">
									<input type="radio" name="payment_method" value="bkash" checked>
									<label>Bkash</label>
								</div>

								<div class="payment_option_checkbox">
									<input type="radio" name="payment_method" value="cash">
									<label>Cash</label>
								</div>
								<input type="hidden" name="discount_code" value="" id="discount_code" >
								<input type="hidden" name="discount_value" value="" id="discount_value" >
								<input type="hidden" name="vat" value="<?= $vat_amount; ?>" >
								<input type="hidden" name="invoice_no" value="<?php echo 'Inv-'.time(); ?>"> 
								<input type="hidden" name="package_id" value="<?php echo $package->id; ?>">
							</div>

							<button type="submit" class="btn buy_now_button ">Confirm</button>

							<a class="membership_cancel" href="<?= Url::toRoute(['page/membership'])?>">Cancel</a>
							

					<?php ActiveForm::end(); ?>

			</div>
			
		</div>
	</div>
</div>

<?php

	 $this->registerJs("
    
        $(document).ready(
            $(document).delegate('.discount_verfication', 'beforeSubmit', function(event, jqXHR, settings) {
                
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


                                $('.invalid_discount_code').html(dt.message);
                              
                                if(dt.status == 1){
                                	$('#discount_value').val(dt.discounts_value);
                                	$('#discount_code').val(dt.discounts_code);
                                	$('.get_calculate_discount').html(dt.calculate_data);
                                }
                                
                               
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "discount_verfication");

?>