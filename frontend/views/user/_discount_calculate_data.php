<?php

	if($validate_data->discounts_type =='Membership'){
		$discount_value = floor(($validate_data->discounts_amount * $total_amount)/100);
	}else{
		$discount_value = 0;
	}
	
	$sub_total_q = $total_amount -  $discount_value;
	$vat_value = ($vat_amount * $total_amount)/100;
	$total_amount_q = $sub_total_q + $vat_value;
?>

<div class="discounts_amounts">
<?php
	if($validate_data->discounts_type =='Membership'){
		echo '<span class="label">Discounts :</span> '.$discount_value .' tk';
	}else{
		echo '<span class="label">Free Points :</span>'. $validate_data->discounts_amount;
	}
?>
</div>
<div class="total_amount"><span class="label">Sub Total :</span> <?= $sub_total_q . ' tk'; ?></div>
<div class="vat_amount"><span class="label">Vat( excluded ) :</span> <?= $vat_value . ' tk';?></div>
<div class="total_amount"><span class="label">Total Amount :</span> <?= $total_amount_q . 'tk'; ?></div>