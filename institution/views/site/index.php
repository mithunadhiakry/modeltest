<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
$this->title = 'Institution | Model Test';

?>
<div class="container">
	<div class="row">
		<div class="inner_container">


			<div class="col-md-5 margin-top-30">
				<div class="profile_container">
					<div class="common_header">
						Profile
					</div>
					<div class="ac_profile_image_points_container margin-right-30">
						<div class="profile_image_container">
							<?php
                                if(!empty($user_data->image)){
                            ?>
                                <img src="<?= Url::base('') ?>/user_img/<?= $user_data->image ?>">
                            <?php  }else{ ?>
                                <img src="<?= Url::base('') ?>/images/profile_avater.jpg">
                            <?php  }  ?>
                      	</div>						
					</div>

					<div class="ac_profile_points_detail float-left ">
						<p class="ac_profile_points_name"><?= $user_data->name ?></p>
						<p>
							<?= $user_data->email ?><br/>
							<?= $user_data->phone ?><br/><br/>
							<?= $user_data->address ?>
						</p>
					</div>
					<a class="view_my_profile" href="<?= Url::toRoute(['site/account']); ?>">View Profile</a>
				</div>				
			</div>



			<div class="col-md-7  margin-top-30">
				<div class="exam-report-question-section" style="padding:0;">
					
					<div class="col-md-6 padding-left-0">
						<div class="dashboard-box">
							<div class="dashboard_icon">
								<i class="fa fa-columns"></i>
							</div>
							<div class="dashboard_right">
								Total Courses <br> 17								
							</div>
						</div>

						<div class="dashboard-box">
							<div class="dashboard_icon ">
								<i class="fa fa-user-plus"></i>
							</div>
							<div class="dashboard_right">
								Total Students <br> 200
							</div>
						</div>


					</div>


					<div class="col-md-6 padding-right-0">
						<div class="dashboard-box">
							<div class="dashboard_icon ">
								<i class="fa fa-columns"></i>
							</div>
							<div class="dashboard_right">
								Total Batches<br> 

								10
							</div>
						</div>

						<div class="dashboard-box">
							<div class="dashboard_icon ">
								<i class="fa fa-money"></i>
							</div>
							<div class="dashboard_right">
								Today's Date <br>
								<?php
									echo Date('d-M-Y');

								?>
							</div>
						</div>
					</div>



				</div>
			</div>

		
		</div>
	</div>
</div>
		