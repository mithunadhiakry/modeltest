<table cellpadding="10" style="width:100%;background-color: rgb(238,242,245);font-family:'segoeui','arial'">
	<tr>
		<td colspan="2" style="padding:40px 30px 15px 30px;">
			<img src="http://model-test.com/demo/images/maillogo.png">
		</td>
	</tr>
	<tr align="center" style="border:1px solid rgba(0,0,0,.1);background: #fff none repeat scroll 0 0;float: left;font-size: 15px;margin: 1%;width: 98%;">
		<td colspan="2" style="padding:50px 100px;color:rgb(105,103,104);line-height:25px;">
			<span style="float: left;font-size: 24px;margin-bottom: 12px;text-align: center;width: 100%;">Hello <?= $signup_model->name;?></span> <br/>
				

				<?php if($signup_model->user_type != 'institution'):?>
					
					Your signed up request need to confirm your email address to complete registration.					
					<br/><br/> Please click on the conform button below.

				<?php else: ?>

					Congratulation! Now you are an official member of this website. But we want to need varifiy your institution.
					<br/><br/>After our varification, you are the authorized member of our webiste.

				<?php endif;?>
		</td>
	</tr>

	<?php if($signup_model->user_type != 'institution'):?>
		<tr align="center">
			<td style="padding-bottom: 40px;padding-top: 20px;">
				<a style="background: rgb(204, 33, 41) none repeat scroll 0 0;color: #fff;padding: 10px 100px;text-decoration: none;" href="<?= Yii::$app->urlManager->createAbsoluteUrl('/')?>site/active_member?auth_key=<?= $signup_model->auth_key; ?>">Confirm</a>
			</td>
		</tr>
	<?php endif;?>

	<tr align="center" style="background: rgb(233, 237, 240) none repeat scroll 0 0;border-bottom: 1px solid rgba(0, 0, 0, 0.1);border-top: 1px solid rgba(0, 0, 0, 0.1);float: left;font-size: 15px;margin: 1%;padding-bottom: 5px;padding-top: 5px;width: 98%;">		
		<td style="">
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