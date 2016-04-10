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