<?php
	
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