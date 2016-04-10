<?php

use yii\helpers\Url;
?>
<?php
	if(!empty($image)){
?>

	<div class="col-md-3 post_image_<?php echo $image->id; ?>" image_id="<?php echo $image->id; ?>" style="display:inline-block;">
		<div class="image_cont">
			<div class="uploaded_image_wrap">
				<img src="<?php echo Url::base().'/advertisement/'.$image->image; ?>" alt="<?php echo $image->image; ?>" width="100%">
			</div>
		</div>
	</div>

<?php
	}
?>
