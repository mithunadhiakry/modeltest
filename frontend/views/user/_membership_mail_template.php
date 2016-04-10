<?php
	$net_price = $package->price_bd * $package->duration/30;

	if(!empty($discounts_data) && $discounts_data->discounts_type == 'Membership'){
		$discount = ($membership_model->discount * $net_price)/100;
	}else{
		$discount = 0;
	}
	
	$sub_total = $net_price - $discount;
	$vat_amount = ($net_price * $membership_model->vat)/100;
	$total_amount = $sub_total + $vat_amount;
?>

<table cellpadding="10" style="width:100%;background-color: rgb(238,242,245);font-family:'segoeui','arial'">
	<tr>
		<td colspan="2" style="padding:40px 30px 15px 30px;">
			<img src="http://model-test.com/demo/images/maillogo.png">
		</td>
	</tr>
	<tr >
		<td colspan="2" style="padding-top:40px;padding-bottom:40px;">
			<strong>Invoice No:</strong> <?php echo $invoice_no; ?><br/>
			<strong>Payment Type:</strong> <?php echo $membership_model->payment_type; ?><br/>
			<strong>Date:</strong> <?php echo Date('Y-m-d'); ?>
		</td>

		<td colspan="2" style="padding-bottom:50px;text-align:right;">
			<?php echo $model->name; ?><br/>
			<?php echo $model->email; ?><br/>
			<?php echo $model->phone; ?><br/><br/>
			<?php echo $model->address; ?>
			
		</td>		
	</tr>

</table>
<table cellpadding="10" style="width:100%;background-color: rgb(238,242,245);font-family:'segoeui','arial'">
	<tr>
		<td style="border-left: 1px solid rgba(0,0,0,.1);border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);">Points</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);">Duration</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);">Share exam</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);">Save Exam</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);">Advanced Reporting</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-top: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);text-align:right;">Price</td>
	</tr>
	<tr>
		<td style="border-left: 1px solid rgba(0,0,0,.1);border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);"><?= $package->package_type; ?></td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);">
			<?php
				echo ($package->duration/30) . ' month';
			?>
		</td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);"><?= $package->share_exam; ?></td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);"><?= $package->save_exam; ?></td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);"><?= $package->advanced_reporting; ?></td>
		<td style="border-bottom: 1px solid rgba(0,0,0,.1);border-right: 1px solid rgba(0,0,0,.1);text-align:right;">Tk. <?= $net_price; ?></td>
	</tr>

	<?php
		if(!empty($discounts_data) && $discounts_data->discounts_type == 'Membership'){
	?>
			<tr>
				<td colspan="5" style="text-align:right;padding-right:15px;padding-bottom:0px;">
					Discount: 
				</td>
				<td style="padding-bottom:0px;text-align: right;">Tk. <?= $discount; ?></td>
			</tr>

	<?php }else{ ?>

			<tr>
				<td colspan="5" style="text-align:right;padding-right:15px;padding-bottom:0px;">
					Free Points: 
				</td>
				<td style="padding-bottom:0px;text-align: right;">Tk. <?php if(!empty($membership_model->discounts_amount)){ echo $membership_model->discounts_amount; }else{ echo '0'; }; ?></td>
			</tr>
	<?php } ?>
	

	<tr>
		<td colspan="5" style="text-align:right;padding-right:15px;padding-bottom:0px;">
			Sub Total:
		</td>
		<td style="padding-bottom:0px;text-align: right;">Tk. <?= $sub_total; ?></td>
	</tr>

	<tr>
		<td colspan="5" style="text-align:right;padding-right:15px;padding-bottom:0px;">
			Vat( excluded )
		</td>
		<td style="padding-bottom:0px;text-align: right;">Tk. <?= $vat_amount; ?></td>
	</tr>

	<tr>
		<td colspan="5" style="text-align:right;padding-right:15px;padding-bottom:70px;">
			Total Amount (unpaid)
		</td>
		<td style="padding-bottom:70px;text-align: right;">Tk. <?= $total_amount; ?></td>
	</tr>
	
	<tr align="center" >		
		<td style="background: rgb(233, 237, 240) none repeat scroll 0 0;border-bottom: 1px solid rgba(0, 0, 0, 0.1);border-top: 1px solid rgba(0, 0, 0, 0.1);font-size: 15px;margin: 1%;padding-bottom: 15px;padding-top: 15px;width: 98%;" colspan="6">
			<span style="color: rgb(163, 164, 166);float: left;font-size: 20px;letter-spacing: 8px;padding-bottom: 12px;text-transform: uppercase;width: 100%;">Social Network</span>
    		<a href="https://www.facebook.com/modeltest4practice"><img style="margin-right:35px;" src="http://model-test.com/demo/images/logo-facebook.png"></a>
    		<a href="https://twitter.com/ModelTestDotCom"><img style="margin-right:35px;" src="http://model-test.com/demo/images/logo-twitter.png"></a>
    		<a href="https://plus.google.com/+Modeltest4Practice"><img style="margin-right:35px;" src="http://model-test.com/demo/images/logo-google.png"></a>
    		<a href="https://www.youtube.com/c/modeltest4practice"><img style="margin-right:10px;" src="http://model-test.com/demo/images/logo-youtube.png"></a>
		</td>
	</tr>

	<tr align="center">
		<td colspan="6" style="color:rgb(105,103,104);font-size:15px;padding-bottom:30px;">
			<span style="width:100%;float:left;padding-top:15px;">For any help, contact @ ABEDON</span>
			<span style="float: left;font-size: 16px;margin-top:5px;margin-bottom: 8px;width: 100%;">Call: 01920806940, 01879142337, 01629965909, 01701757710 </span>
			<span style="float: left;font-size: 20px;margin-bottom: 8px;width: 100%;"><a style="color: rgb(184, 201, 229);text-decoration: none;" href="mailto:support@model-test.com">support@model-test.com</a></span>
			
		</td>
	</tr>
</table>
