<?php
	$this->title = $get_page_data->page_title.' | Model Test';

?>

<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="inner_common_page margin-top-30">
				<?php
					echo $get_page_data->page_desc;
					if(!empty($get_page_data->post)){
						foreach($get_page_data->post as $post_data){
				?>
					<h3><?php echo $post_data->post_title; ?></h3>
					<div class="margin-top-30">
						<?php

							if(!empty($post_data->desc)){
								echo $post_data->desc;
							}else{
								echo 'This page under construction';
							}
						?>
					</div> 

				<?php
						}
					}else{
						echo 'This page under construction';
					}
				?>
			</div>
		</div>
	</div>
</div>