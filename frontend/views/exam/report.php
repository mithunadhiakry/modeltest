<?php
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
    use yii\helpers\Html;

    use frontend\models\Rest;
	$this->title ="Exam Report | Model Test";

	$total_question = count($question_list);
	$answered = 0;
	$correct = 0;
	$total_answer_number = 0;
	$incorrect = 0;
	$score = 0;
	$Percentage = 0;
	foreach ($question_list as $question) {
		if($question['is_correct'] != 0 && $question['mark_for_review'] == 0){
			$answered++;

			if($question['answer_id'] != 0){
				$total_answer_number++;
			}
			if($question['is_correct'] == $question['answer_id']){
				$correct++;
				$score = $score+2;
				//echo $question['is_correct'].'.....'.$question['answer_id'].'<br/>';
			}else{
				$incorrect++;
				$score = $score-1;
			}
		}
		
	}

	if($correct > 0){
		$Percentage = round(($correct*100)/$total_question,2);
	}
	
	$time_spent = Rest::get_number_of_seconds_from_time($exam_data->time_spent);

	$session = Yii::$app->session;
	if($session->has('share_facebook_report')){
		$fb_share = $session->get('share_facebook_report');
        $session->remove('share_facebook_report');
	}else{
		$fb_share = 0;
	}
	
?>


    
<!-- Start of report  -->
		
			<div class="container">
				<div id="fb-root"></div>
				<div class="row">
					<div class="report_container margin-bottom-20">
						<div class="col-md-4 padding-left-0">
							
							<?=
								$this->render('report_sidebar',[
										'exam_data' => $exam_data,
										'assign_exam_list_r' => $assign_exam_list_r,
										'get_page_data' => $get_page_data,
										'total_question' => $total_question,
										'answered' => $answered,
										'correct' => $correct,
										'incorrect' => $incorrect,
										'score' => $score,
										'Percentage' => $Percentage,
										'time_spent' => $time_spent,
										'advertisement_print_r' => $advertisement_print_r,
										'question_list' => $question_list,
										'total_answer_number' => $total_answer_number
									]);

							?>

							<div class="report-container-2 margin-top-20">

								<div class="common-header summarized-report-header-bg  ">
									<a href="#" class="width100 textalignleft active">Question wise report</a>
								</div>

								<div class="common-body question-wise-report-header" >
									
									<div class="exam-wise-report-container">
										<div class="exam_list_icon exam_report_icon">
											<?php
												foreach ($question_list as $question_item) {
													$item_class='';

													if($question_item['is_correct'] == $question_item['answer_id']){
														$item_class = 'circle correctanswer';
													}else{
														$item_class = 'circle wrong-answer';
													}
													
											?>

												<a href="#" data-item-id="<?= $question_item['serial']; ?>" id="q_<?= $question_item['serial'].$question_item['question_id']; ?>" class="<?= $item_class; ?>"><?= $question_item['serial']; ?></a>

											<?php
												}
											?>
											
										</div>
									</div>
									
								</div>
							</div>

							<div class="report-container-2 margin-top-20">

								<?php

									if($exam_data->time_spent != 0):
								?>

										<div class="common-header summarized-report-header-bg">
											<a href="<?= Url::toRoute(['exam/summarize_report','exam_id'=>$exam_data->exam_id]); ?>" class="width100 textalignleft">Summarize report</a>
										</div>

								<?php endif;?>

							</div>

							<?php
	                            if(!empty($advertisement_r)){
	                                $count = 1;
	                                foreach($advertisement_r as $advertisement){
	                        ?>
	                                
	                                    <div class="advertisement <?php if($count != 1){ echo 'margin-top-30';} ?> ">
	                                        <a href="<?= $advertisement->url; ?>" target="_blank">
	                                            <img src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement->image; ?>">
	                                        </a>
	                                    </div>

	                        <?php
	                                $count++;
	                                    }
	                                }
	                        ?>

						</div>

						<div class="col-md-8 padding-right-0">
							
							<div class="exam-report-question-section">
								
								<div class="question-list-container" data-cur-item="1" data-exam-id="<?= $exam_data->exam_id; ?>">

									

									<div class="question-list">
										
									</div>

									<div class="css_loader_container_wrap">
										<div class="css_loader_container">
											<div class="cssload-loader"></div>
										</div>
									</div>

									<div class="question_report_container">
										<div class="left_arrow">
											<a href="#" >
												<img src="<?= Url::base('') ?>/css/images/arrow.png">
											</a>
										</div>

										<div class="right_arrow">
											<a href="#">
												<img src="<?= Url::base('') ?>/css/images/arrow.png">
											</a>
										</div>
									</div>

								</div>


								

							</div>

						</div>
					</div>
				</div>
			</div>



		<!-- end of report -->



<?php
	
	$this->registerJs("
		var item = parseInt($('.question-list-container').attr('data-cur-item'));
		var exam_id = $('.question-list-container').attr('data-exam-id');
		
		get_new_question(item,exam_id);


		$('.left_arrow a').on('click',function(){
			var item = parseInt($('.question-list-container').attr('data-cur-item'));
			var exam_id = $('.question-list-container').attr('data-exam-id');
			if(item != 0){
				get_new_question((item-1),exam_id);
			}else{
				
				BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': 'No previous question.'
								});
			}
		})

		$('.right_arrow a').on('click',function(){
			var item = parseInt($('.question-list-container').attr('data-cur-item'));
			var exam_id = $('.question-list-container').attr('data-exam-id');
			
			get_new_question((item+1),exam_id);
		})

		$('.exam_list_icon a').on('click',function(){
			var item = $(this).attr('data-item-id');
			var exam_id = $('.question-list-container').attr('data-exam-id');
			
			get_new_question(item,exam_id);
		});


		function get_new_question(item,exam_id){
			$.ajax({
	            type : 'POST',
	            dataType : 'json',
	            url : '".Url::toRoute('rest/get_new_report_question')."',
	            data: {item:item,exam_id:exam_id},
	            beforeSend : function( request ){
	            	$('.css_loader_container_wrap').fadeIn();
	            },
	            success : function( data )
	                {   
	                	$('.css_loader_container_wrap').fadeOut();
	                	if(data.result == 'success'){
		                	$('.question-list').html(data.message);
		                	$('.question-list-container').attr('data-cur-item',data.item)
		                }
	                    else if(data.result == 'error'){
	                    	alert(data.message);
	                    }
	                }
	        });

			return false;
		}

	", yii\web\View::POS_READY, "exam_selection_checkbox_CHECKED");
	

	



	$this->registerJs("
		window.fbAsyncInit = function() {
	          FB.init({
	            appId      : '709957295722222',
	            cookie     : true,  // enable cookies to allow the server to access 
	                                // the session
	            xfbml      : true,  // parse social plugins on this page
	            version    : 'v2.2' // use version 2.2
	          });

				if (typeof facebookInit == 'function') {
			        checkLoginState();
			    }

          };

          // Load the SDK asynchronously
          (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = '//connect.facebook.net/en_US/sdk.js';
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));


        // This is called with the results from from FB.getLoginStatus().
          function statusChangeCallback(response) {
            console.log('statusChangeCallback');
            console.log(response);

            if (response.status === 'connected') {
              // Logged into your app and Facebook.
              testAPI();
            } else if (response.status === 'not_authorized') {
              // The person is logged into Facebook, but not your app.
              document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
            } else {
              // The person is not logged into Facebook, so we're not sure if
              // they are logged into this app or not.
              document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
            }
          }

          var fb_share = '".$fb_share."';
          if(fb_share == '1'){
          	setTimeout(function(){
	          	checkLoginState();
	          },5000);
          }
          
          

          function checkLoginState() {
          	
          	FB.login(function(response) {
			   if (response.authResponse) {
			     statusChangeCallback(response);
			   } else {
			     console.log('User cancelled login or did not fully authorize.');
			   }
			 });

          }

         
          function testAPI() {
            FB.ui({
			  method: 'share',
			  href: 'http://dcastalia.com/projects/web/model_test',
			}, function(response){
				var exam_id = '".$exam_data->exam_id."';
				if(response.post_id){
					$.ajax({
		            	type : 'POST',
			            dataType : 'json',
			            url : '".Url::toRoute('rest/save_fb_share_point')."',
			            data: {exam_id:exam_id},
			            beforeSend : function( request ){
			            	$('.css_loader_container_wrap').fadeIn();
			            },
			            success : function( data )
			                {   
			                	$('.css_loader_container_wrap').fadeOut();
			                	if(data.result == 'success'){
				                	alert(data.msg);
				                }
			                    else if(data.result == 'error'){
			                    	alert(data.msg);
			                    }
			                }
			        });
				}

			});
            
          }       
    ", yii\web\View::POS_READY, 'fb_login');

	
?>