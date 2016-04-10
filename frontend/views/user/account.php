<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	$this->title = 'My Exam | Model Test';
?>

<div class="container">
	<div class="row">
		<div class="inner_container">

			
			<div class="accounts_cont_area">					    	
		    	<div class="ac_point account_ac_point">
			    	<h3>Points status</h3>
			    	<div class="pointpayment_rightbar">
				    	<span class="total_points">Your total points: <?= $sum_of_points+Yii::$app->user->identity->free_point; ?></span>
				    </div>
		    	</div>
		    	<div class="ac_point account_ac_point">
			    	<h3>Redeemed points</h3>			    	
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

	", yii\web\View::POS_READY, "load_more");

?>