<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	use frontend\models\Discounts;

	$this->title = "Discounts | Model Test";
?>

<div class="container">
	<div class="row">
		<div class="inner_container">


			<div class="invoice_section">

				<div class="invoice_header margin-top-30">
					Discounts
				</div>

				<div class="invoice_details">
					<div class="col-md-12 margin-top-30">
						<div class="row">
							<?= $discounts_text->page_desc;  ?>
						</div>
					</div>
				</div>

				<?php
					if(!empty($discounts_data)):

				?>

				<div class="discount_container_tab">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">

				  	<?php
				  	
				  		foreach($discounts_data as $discounts){	
				  	?>	
				  			
				  			<li role="presentation" class="<?php if(Date('n') == $discounts->discounts_slot){echo 'active';} ?>">
				  				<a href="#<?= $discounts->discounts_month; ?>" role="tab" data-toggle="tab"><?= $discounts->discounts_month . ' '.$discounts->discounts_year; ?></a>
				  			</li>


				  	<?php
				  		
				  		}
				  	?>
				    
				    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

				  	<?php
				  	
				  		foreach($discounts_data as $discounts){

				  	?>
				  		

				  			<div role="tabpanel" class="tab-pane <?php if(Date('n') == $discounts->discounts_slot){echo 'active';} ?>" id="<?= $discounts->discounts_month; ?>">
				  	
				  				<table class="table membership-payment margin-top-30 width100 text-align-center">

				  					<tr>
										<td>Discount Name</td>
										<td>Discount Offer</td>
										<td>Discount Code</td>
										<td>Start Date</td>
										<td>End Date</td>
									</tr>

									<?php
										
										$discounts_value_r = Discounts::find()
															->where(['discounts_month' => $discounts->discounts_month ])
															->andWhere(['status' => 1])
															->all();

										foreach($discounts_value_r as $discounts_value){
									?>
											<tr>
												<td>
														<?= $discounts_value->discounts_name; ?>
												</td>	
												<td>
													<?php 
														
														if($discounts_value->discounts_type == 'Membership'){
															echo $discounts_value->discounts_amount . ' % off';
														}else{
															echo $discounts_value->discounts_amount . ' Extra Free Points';
														}
													?>
												</td>

												<td>
													<?= $discounts_value->discounts_code ?>
												</td>
												<td>
													<?= $discounts_value->start_date; ?>
												</td>	
												<td>
													<?= $discounts_value->end_date; ?>
												</td>	
											</tr>

									<?php
										}
									?>
				  				</table>

				  			</div>
				  	<?php 
				  		}
				  	?>

				  		
				    
				  </div>

				</div>
				

				<?php

					else:
						echo '<div class="margin-top-30 width100">Sorry, no discounts yet</div>';
					endif;
				?>
			</div>


		</div>
	</div>
</div>