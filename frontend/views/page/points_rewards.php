<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->title = "Points & Rewards | Model Test";
?>
<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="inner_common_page margin-top-30">

				<!-- Point Post -->
				<?php
					if(!empty($get_point_data->post)){
						foreach($get_point_data->post as $point_data){
				?>
							<h3 class="points_header_border"><?php echo $point_data->post_title; ?></h3>
							<div class="margin-top-15"><?php echo $point_data->desc; ?></div>
				<?php
						}
					}
				?>
				

				<!-- point list -->
				<?php
					if(isset($all_point_data_r)){
				?>
					<table class="table membership-payment margin-top-30 margin-bottom-30">
						
							<tr>
								<td>
									Actions
								</td>
								<td class="text-align-center">
									Points
								</td>
							</tr>
													
				<?php
						foreach($all_point_data_r as $all_point_data){
				?>
							
							<tr>
								<td><?= $all_point_data->name; ?></td>
								<td class="text-align-center"><?= $all_point_data->points; ?></td>
							</tr>
				<?php
						}	
				?>
					
					<tr>
						<td>Posting Abusive Or Non-Community Friendly Content On Facebook Fan Page</td>
						<td class="text-align-center">A Penalty, Could Be Block Or Suspension Of Account</td>
					</tr>
					</table>
				<?php					
					}
				?>
	
				<!-- rewards posts -->
				<?php
					if(!empty($get_rewards_data->post)){
						foreach($get_rewards_data->post as $rewards_data){
				?>
							<h3 class="points_header_border"><?php echo $rewards_data->post_title; ?></h3>
							<div class="margin-top-15"><?php echo $rewards_data->desc; ?></div>
				<?php
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

