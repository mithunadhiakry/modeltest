<!-- start of inner container -->
<?php
	
	use yii\helpers\Url;
	use frontend\models\Category;
	use frontend\models\Subject;
	use frontend\models\Chapter;
	use frontend\models\Question;

	$session = Yii::$app->session;
	if($session->has('chapter_list')){
		$chapter_list_session = $session->get('chapter_list');
    }else{
    	$chapter_list_session = array();
    }

    $session->set('redirect_url','exam/examcenter');
    // $session->set('redirect_url',Yii::$app->request->absoluteUrl);
	$this->title = 'Exam Center | Model Test';

	$categories = Category::find()->andWhere(['!=','parent_id',0])
								->andWhere(['!=','parent_id',59])
								->orderBy('category_name asc')
								->all();
	
	
?>



<div class="container">
	<div class="row">
		<div class="row">
			<div class="inner_container">
			<div class="exam_center_container_box1">
				<div class="col-md-9">
					<div class="exam_center_container">
						<?php
							if(!empty($get_examcenter_data->post)){
								foreach($get_examcenter_data->post as $examcenter_data){
						?>
							<div class="inner_header"><?php echo $examcenter_data->post_title; ?></div>
							<div class="inner-content"><?php echo $examcenter_data->desc; ?></div> 

						<?php
								}
							}
						?>
						
					</div>
				</div>
				<div class="col-md-3">
					<div class="exam_center_container">

						<?php
                            if(!empty($advertisement_top_right_r)){
                                $count = 1;
                                foreach($advertisement_top_right_r as $advertisement){
                        ?>
                                
                                    <div class="advertisement_container <?php if($count != 1){ echo 'margin-top-20';} ?> ">
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
				</div>
			</div>
			
			<!-- end of exam_center_container_box1 -->



			<div class="exam_center_container_box2">							
				<div class="col-md-9">					
					<div class="exam_selection_area">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								
								<?php
									$count = 1;
									if(isset($get_all_country_r)){

										foreach($get_all_country_r as $get_all_country){
								?>

											<div class="panel-heading" role="tab" id="heading<?= $get_all_country->id;?>">
											      <h4 class="panel-title">
											        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#exam_in_center<?= $get_all_country->id;?>" aria-expanded="true" aria-controls="collapseOne">
											          All Exams
											          <!-- <span class="arrow_button">
												          <i class="fa fa-angle-down"></i>
												      </span> -->
											        </a>
											      </h4>
											    </div>


											    <div id="exam_in_center<?= $get_all_country->id;?>" class="panel-collapse collapse <?php if($count == 1){echo 'in';} ?>" role="tabpanel" aria-labelledby="heading<?= $get_all_country->id;?>">
													<div class="panel-body">
														<div class="row">
															<div class="col-md-3 padding-right-0">
												  				
																<?php
																	$category_list_r = Category::get_all_category_list($get_all_country->id);
																	$category_no = 1;
																?>
																<ul class="nav nav-pills nav-stacked" id="exam_selection_left_tab">
																	<span class="paid_exam">Practice Exam</span>
																   	<?php
																   	$show_paid_exam = 1;
																   		if(isset($category_list_r)){
																   			foreach($category_list_r as $category_list){
																   				
																   				if($category_list->id == 60 || $category_list->id == 59){
																   					if($show_paid_exam == 1){
																   	?>
																   					<span class="paid_exam">Special Exam</span>
																   					<?php $show_paid_exam++; }  ?>
																					<li class="<?php if($category_no == 1)echo 'active'; ?>"><a href="#category_selection<?=$category_list->id;?>"><?= $category_list->category_name ?></a></li>
																   	<?php
																   				}else{
																   	?>
																					<li class="<?php if($category_no == 1)echo 'active'; ?>"><a href="#category_selection<?=$category_list->id;?>"><?= $category_list->category_name ?></a></li>
																   	<?php
																   				}
																   	?>
																				
																   	<?php
																   			$category_no++;
																   			}
																   		}
																   	?>										    

																</ul>

																<?php
										                            if(!empty($advertisement_bottom_left_r)){
										                               
										                                foreach($advertisement_bottom_left_r as $advertisement){
										                        ?>
										                                
										                                    <div class="advertisement_container margin-top-20">
										                                        <a href="<?= $advertisement->url; ?>" target="_blank">
										                                            <img src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement->image; ?>">
										                                        </a>
										                                    </div>

										                        <?php										                                
										                                    }
										                                }
										                        ?>
																
															</div>

															<div class="col-md-9 padding-left-0">												  	
													    		<div class="tab-content">
																	<?php
																		$category_no = 1;
																   		if(isset($category_list_r)){
																   			foreach($category_list_r as $category_list){
																   	?>
																				<div class="tab-pane <?php if($category_no == 1)echo 'active'; ?>" id="category_selection<?=$category_list->id;?>">
																					
																					<div class="exam_container_all">
																						<?php
																							if($category_list->id == '60'){
																								$get_sub_category_r = $categories;
																								echo Yii::$app->controller->renderPartial('_exam_centre_model_test',[
																																			'get_sub_category_r'=>$get_sub_category_r,
																																			'category_list' => $category_list,
																																			'chapter_list_session' => $chapter_list_session
																																		]);
																							}else{
																								$get_sub_category_r = Category::get_sub_category($category_list->id);
																								echo Yii::$app->controller->renderPartial('_exam_centre_test_exam',[
																																			'get_sub_category_r'=>$get_sub_category_r,
																																			'category_list' => $category_list,
																																			'chapter_list_session' => $chapter_list_session
																																		]);
																							}
																						?>
																						

																						
																					</div>
																				</div>
																   	<?php
																   			$category_no++;
																   			}
																   		}
																   	?>
													    		</div>
													    	</div>
			
															<?php

																$this->registerJs("
																	
																	$('#exam_selection_left_tab a').click(function (e) {
																	    e.preventDefault()
																	    $(this).tab('show')
																	  });

																", yii\web\View::POS_READY, "$get_all_country->id");
															?>
															
														</div>
													</div>
												</div>

								<?php
									$count++;
										}
									}

								?>
								
	

							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-3">
					
					<?php if(!empty($chapter_list_session)){ ?>	
					<style>
						.exam_selection_selected_container{display: block;}
					</style>
					<div class="exam_selection_selected_container">
						<div class="header">
							Selected Items

						</div>
						<div class="selected_container_body">
							<div class="css_loader_container_wrap">
								<div class="css_loader_container">
									<div class="cssload-loader"></div>
								</div>
							</div>
							<ul>
								<?php

									
										foreach ($chapter_list_session as $key) {
											$chapter_data = Chapter::find()->where(['id'=>$key])->one();
											if(!empty($chapter_data)){
								?>

									<li class="selected_item<?= $chapter_data->id; ?>">
										<?= $chapter_data->chaper_name; ?> <span class="selected_subject_name">(<?= $chapter_data->subject->subject_name; ?>)</span>
										<span class="remove remove_selected_chapter" data-selected-id="<?= $chapter_data->id; ?>">
											<img src="<?= Url::base('') ?>/images/cross_1.png">
										</span>
									</li>

								<?php
											}
										}
									

								?>
								
							</ul>
						</div>
						
						<div class="selected_number_of_question_container">
							<div class="text">Number of Question</div>
							<div class="inputfiled">
								<input type="text" placeholder="__" name="number_of_question" class="number_of_question">
							</div>
						</div>

						<div class="selected_number_of_question_container">
							<div class="text">Time Limit in Minutes</div>
							<div class="inputfiled">
								<input type="text" placeholder="__" name="time_limit" class="time_limit">
							</div>
						</div>
						<?php
							if(Yii::$app->user->isGuest) {
						?>
							<div class="submit_container">
								<p>You need to<a style="color:#f3502b;" href="<?= Url::toRoute(['site/login']); ?>"> Sign in</a> first to participate an exam </p>
							</div>
						<?php
							}else{
						?>
							<div class="submit_container">
								<input type="submit" name="submit" value="Continue" class="selection_submit">
							</div>
						<?php
							}
						?>
						

					</div>	

					<?php }else{?>

						<div class="exam_selection_selected_container">
						<div class="header">
							Selected Items

						</div>
						<div class="selected_container_body">
							<div class="css_loader_container_wrap">
								<div class="css_loader_container">
									<div class="cssload-loader"></div>
								</div>
							</div>
							<ul>
								<?php

									
										foreach ($chapter_list_session as $key) {
											$chapter_data = Chapter::find()->where(['id'=>$key])->one();
											if(!empty($chapter_data)){
								?>

									<li class="selected_item<?= $chapter_data->id; ?>">
										<?= $chapter_data->chaper_name; ?> <span class="selected_subject_name">(<?= $chapter_data->subject->subject_name; ?>)</span>
										<span class="remove remove_selected_chapter" data-selected-id="<?= $chapter_data->id; ?>">
											<img src="<?= Url::base('') ?>/images/cross_1.png">
										</span>
									</li>

								<?php
											}
										}
									

								?>
								
							</ul>
						</div>
						
						<div class="selected_number_of_question_container">
							<div class="text">Number of Question</div>
							<div class="inputfiled">
								<input type="text" name="number_of_question" class="number_of_question">
							</div>
						</div>

						<div class="selected_number_of_question_container">
							<div class="text">Time Limit in Minutes</div>
							<div class="inputfiled">
								<input type="text" name="time_limit" class="time_limit">
							</div>
						</div>
						<?php
							if(Yii::$app->user->isGuest) {
						?>
							<div class="submit_container">
								<p>Please <a href="<?= Url::toRoute(['site/login']); ?>">login</a> to continue.</p>
							</div>
						<?php
							}else{
						?>
							<div class="submit_container">
								<input type="submit" name="submit" value="Continue" class="selection_submit">
							</div>
						<?php
							}
						?>
						

					</div>

					<?php } ?>





					<?php
                            if(!empty($advertisement_bottom_right_r)){
                                
                                foreach($advertisement_bottom_right_r as $advertisement){
                        ?>
                                
                                    <div class="advertisement_container margin-top-20">
                                        <a href="<?= $advertisement->url; ?>" target="_blank">
                                            <img src="<?= Yii::$app->urlManagerBackEnd->baseUrl ?>/advertisement/<?= $advertisement->image; ?>">
                                        </a>
                                    </div>

                        <?php
                                
                                    }
                                }
                        ?>	
			

				</div>

			</div>

			<div class="exam_center_container_box3">

				<div class="col-md-12">
					<div class="exam_center_bottom">
						<div class="header">
							Countries some Famous institutions using modeltext.com
						</div>
						
						<div class="row">
						<div class="famous_country_list">
							
							<div class="slider1">

								<?php
									if(!empty($get_institution_list_r)){
										foreach($get_institution_list_r as $get_institution_list){
								?>
											<div class="col-md-2 ">
										    	<div class="row">
										    		<?php
										    			if($get_institution_list->image){
										    		?>
															<img src="<?= Url::base('') ?>/institution/user_img/<?= $get_institution_list->image; ?>">
										    		<?php }else{ ?>
															<img src="<?= Url::base('') ?>/institution/user_img/institution_profile.png">
										    		<?php }	?>
											   		
											   	</div>
											</div>
								<?php
										}
									}
								?>
							    
								

							
							  
							</div>
							
						</div>
						</div>
					</div>
				</div>

			</div>

			<!-- end of exam_center_container_box3 -->


			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="instruction_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">

        	<div class="exam_instruction_container">
	     		<?php                           
	                if(!empty($get_page_data->post)){
	                    foreach($get_page_data->post as $post_data){
	                        echo $post_data->desc;
	                    }
	                }
	            ?>
	        </div>

        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
        	<div class="start_exam_loader">
        		<div class="css_loader_container_wrap">
					<div class="css_loader_container">
						<div class="cssload-loader"></div>
					</div>
				</div>
        	</div>
        	<div class="start_exam_popup_container">
				<div class="width100 start_exam_checkbox">
					<input type="checkbox" name="tick_to_make" id="tick_to_make">
					<label for="tick_to_make">Tick to make sure you read & understand 'Instructions'.</label>
				</div>
				<div class="width100 start_exam_checkbox fb_share_button_for_exam">
					<input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_facebook">
					<label for="share_report_in_facebook" id="share_practice_exam">Share my report to my Facebook's personal wall, at the end of my exam.</label>
				</div>
				<div class="width100">
					<br/>
					Press <strong>Start Exam</strong> button  to begin the exam. All the best.
				</div>
        	</div>
        	<button type="button" class="btn btn-success start_exam_btn">Start Exam</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal -->


<div class="modal fade" id="instruction_modal_model_test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">

        	<div class="exam_instruction_container">
        	
	        	<!-- <div class="model_test_set_id"></div> -->
	     		<?php                           
	                if(!empty($get_page_data->post)){
	                    foreach($get_page_data->post as $post_data){
	                        echo $post_data->desc;
	                    }
	                }
	            ?>
	       </div>


        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
        	<div class="start_exam_loader">
        		<div class="css_loader_container_wrap">
					<div class="css_loader_container">
						<div class="cssload-loader"></div>
					</div>
				</div>
        	</div>
        	<div class="start_exam_popup_container">
				<div class="width100 start_exam_checkbox">
					<input type="checkbox" name="tick_to_make" id="tick_to_make_model_test">					
					<label for="tick_to_make_model_test">Tick to make sure you read & understand 'Instructions'.</label>
				</div>
				<div class="width100 start_exam_checkbox fb_share_button_for_exam">
					<input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_model_test_facebook">
					<label for="share_report_in_model_test_facebook">Share my report to my Facebook's personal wall, at the end of my exam.</label>
				</div>
				<div class="width100">
					<br/>
					Press <strong>Start Exam</strong> button  to begin the exam. All the best.
				</div>
        	</div>
        	<button type="button" class="btn btn-success start_exam_btn_model_test start_exam_btn">Start Exam</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal -->


<div class="modal fade" id="instruction_modal_previous_year_test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
        </div><!-- /modal-header -->
        
        <div class="modal-body">
        	<!-- <div class="model_test_set_id"></div> -->

        	<div class="exam_instruction_container">

        		<div class="exam_instruction_container">

		     		<?php                           
		                if(!empty($get_page_data->post)){
		                    foreach($get_page_data->post as $post_data){
		                        echo $post_data->desc;
		                    }
		                }
		            ?>
		            
		        </div>

	        </div>
        </div><!-- /modal-body -->
        
        <div class="modal-footer text-right">
        	<div class="start_exam_loader">
        		<div class="css_loader_container_wrap">
					<div class="css_loader_container">
						<div class="cssload-loader"></div>
					</div>
				</div>
        	</div>
        	<div class="start_exam_popup_container">
				<div class="width100 start_exam_checkbox">
					<input type="checkbox" name="tick_to_make" id="tick_to_make_previous_year_test">					
					<label for="tick_to_make_previous_year_test">Tick to make sure you read & understand 'Instructions'.</label>
				</div>
				<div class="width100 start_exam_checkbox fb_share_button_for_exam ">
					<input checked type="checkbox" name="share_report_in_facebook" id="share_report_in_previous_year_facebook">
					<label for="share_report_in_previous_year_facebook">Share my report to my Facebook's personal wall, at the end of my exam.</label>
				</div>
				<div class="width100">
					<br/>
					Press <strong>Start Exam</strong> button  to begin the exam. All the best.
				</div>
        	</div>
        	<button type="button" class="btn btn-success start_exam_btn_previous_year_test">Start Exam</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div><!-- /modal-footer -->
        
        </div><!-- /modal-content -->
    </div><!-- /modal-dialog -->
</div><!-- /modal -->
	
<!-- end of inner container -->

<?php

	$this->registerJs("
        
           $(document).ready(function(){
               
               
			 $('.slider1').bxSlider({
			    slideWidth: 190,
			    minSlides: 1,
			    maxSlides: 10,
			    slideMargin: 10,
			    pager:false
			  });

           });
        
        ", yii\web\View::POS_READY, "instruction_slider");
	
	$this->registerJs("
		var number_of_question = '';
		var time_limit = '';
		var selected_chapters = '';
		
		

		

		

		$('.selection_submit').on('click',function (e) {
			number_of_question = parseInt($('.number_of_question').val());
			time_limit = parseInt($('.time_limit').val());
			selected_chapters = $('.selected_container_body ul li').length;

			

			if(number_of_question > 30){
				
				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'You are not allowed to take more than 30 questions.'
				});

				return false;
			}else if(number_of_question < 1){
				
				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'You are not allowed to take less than 10 questions.'
				});

				return false;
			}else if(isNaN(number_of_question)){

				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'Please Select Number of Question & expected time limit'
				});
				return false;
			}
			else if(time_limit > 120){

				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'You are not allowed to take more than 2 hour exam time.'
				});

				return false;

			}else if(time_limit < 1){

				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'You are not allowed to take less than 1 minutes exam time.'
				});

				return false;
			}else if(isNaN(time_limit)){

				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'Please select exam time.'
				});

				return false;
			}
			else{
				if(selected_chapters > 0){

					$('#instruction_modal').modal('show');
				}
			}

            return false;
		});

	
		$('.start_exam_btn').on('click',function(){

			
			
			if($('#share_report_in_facebook').prop('checked') == true){
				var share_facebook_report = 1;
			}else{
				var share_facebook_report = 0;
			}

			
			if($('#tick_to_make').prop('checked') == true){

			
				$.ajax({
		            type : 'POST',
		            dataType : 'json',
		            url : '".Url::toRoute('rest/start_exam_check')."',
		            data: {share_facebook_report:share_facebook_report,number_of_question:number_of_question,time_limit:time_limit},
		            beforeSend : function( request ){
		            	$('#instruction_modal .css_loader_container_wrap').fadeIn();
		            },
		            success : function( data )
		                {   
		                	$('#instruction_modal .css_loader_container_wrap').fadeOut();
		                	if(data.result == 'success'){
			                	window.location = data.redirect_url;
			                }
		                    else if(data.result == 'login_error'){
		                    	window.location = data.redirect_url;
		                    }else if(data.result == 'error'){
		                    
		                    	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                    }
		                }
		        });

			}else{
				
				BootstrapDialog.alert({
					 title: 'WARNING',
					 'message': 'Please read the instruction carefully'
				});
			}
			
			
			return false;
		});



	", yii\web\View::POS_READY, "submit_question_selection");
	
	$this->registerJs("
		
		$('.exam_selection_checkbox').change(function (e) {
			
			$('.exam_selection_selected_container').css({
				'display':'block'
			});
			var flag = '';
			if(this.checked) {
				flag = 'checked';
		    }else{
		    	flag = 'unchecked';
		    }

		    var id = $(this).attr('data-id');
            
            add_remove_item(flag,id);

            return false;
		});

		$(document).delegate('.remove_selected_chapter','click',function(){
			var id = $(this).attr('data-selected-id');
			add_remove_item('unchecked',id);
		})


		function add_remove_item(flag,id){
			$.ajax({
	            type : 'POST',
	            dataType : 'json',
	            url : '".Url::toRoute('rest/add_remove_item')."',
	            data: {flag:flag,id:id},
	            beforeSend : function( request ){
	            	$('.selected_container_body .css_loader_container_wrap').fadeIn();
	            },
	            success : function( data )
	                {   
	                	$('.selected_container_body .css_loader_container_wrap').fadeOut();

	                	if(data.result == 'success'){
		                	if(flag == 'unchecked'){
		                		$('.selected_item'+id).remove();
		                		$('.selection_checkbox_'+id).prop('checked',false);
		                	}else{
		                		$('.selected_container_body ul').append(data.item_data);
		                	}
		                	$('.cart_number span').html(data.total_item);
		                }
	                    else{

	                    }
	                }
	        });
		}

	", yii\web\View::POS_READY, "exam_selection_checkbox_CHECKED");

	$this->registerJs("
		var question_set = '';
		$('.question_set').on('click',function (e) {
			question_set = $(this).attr('data-id');

			//$('.model_test_set_id').html(question_set);
			$('#instruction_modal_model_test').modal('show');

            return false;
		});

	
		$('.start_exam_btn_model_test').on('click',function(){

			if($('#share_report_in_model_test_facebook').prop('checked') == true){
				var share_facebook_report = 1;
			}else{
				var share_facebook_report = 0;
			}

			
			if($('#tick_to_make_model_test').prop('checked') == true){
			
				$.ajax({
		            type : 'POST',
		            dataType : 'json',
		            url : '".Url::toRoute('rest/start_exam_check_model_test')."',
		            data: {share_facebook_report:share_facebook_report,question_set:question_set},
		            beforeSend : function( request ){
		            	$('#instruction_modal_model_test .css_loader_container_wrap').fadeIn();
		            },
		            success : function( data )
		                {   
		                	$('#instruction_modal_model_test .css_loader_container_wrap').fadeOut();
		                	if(data.result == 'success'){
			                	window.location = data.redirect_url;
			                }
		                    else if(data.result == 'login_error'){
		                    	window.location = data.redirect_url;
		                    }else if(data.result == 'error'){
		                    	
		                    	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                    }

		                    
		                }
		        });

			}else{
				
				BootstrapDialog.alert({
						 title: 'WARNING',
						 'message': 'Please read the instruction carefully'
					});
			}
			
			
			return false;
		});



	", yii\web\View::POS_READY, "model_test");

	$this->registerJs("
		var previous_year_question_set = '';
		$('.previous_year_question_set').on('click',function (e) {
			previous_year_question_set = $(this).attr('data-id');

			//$('.model_test_set_id').html(question_set);
			$('#instruction_modal_previous_year_test').modal('show');

            return false;
		});

	
		$('.start_exam_btn_previous_year_test').on('click',function(){

			if($('#share_report_in_previous_year_facebook').prop('checked') == true){
				var share_facebook_report = 1;
			}else{
				var share_facebook_report = 0;
			}
			
			
			if($('#tick_to_make_previous_year_test').prop('checked') == true){
			
				$.ajax({
		            type : 'POST',
		            dataType : 'json',
		            url : '".Url::toRoute('rest/start_exam_check_previous_year_test')."',
		            data: {share_facebook_report:share_facebook_report,chapter:previous_year_question_set},
		            beforeSend : function( request ){
		            	$('#instruction_modal_previous_year_test .css_loader_container_wrap').fadeIn();
		            },
		            success : function( data )
		                {   
		                	$('#instruction_modal_previous_year_test .css_loader_container_wrap').fadeOut();
		                	if(data.result == 'success'){
			                	window.location = data.redirect_url;
			                }
		                    else if(data.result == 'login_error'){
		                    	window.location = data.redirect_url;
		                    }else if(data.result == 'error'){
		                    	
		                    	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                    }
		                }
		        });

			}else{
				
				BootstrapDialog.alert({
								 title: 'WARNING',
								 'message': 'Please read the instruction carefully'
							});
			}
			
			
			return false;
		});



	", yii\web\View::POS_READY, "previous_year_question_set");


	$this->registerJs("
		
		$('.select_all input').change(function (e) {

			var flag = '';
			if(this.checked) {
				flag = 'checked';

				var inputs = $(this).parent().parent().next().find('input[type=\"checkbox\"]');
				$(inputs).each(function(index, val){
					
					if($(val).prop(\"checked\") == false){
						$(val).prop(\"checked\", true);
						var id = $(val).attr('data-id');
						add_remove_item(flag,id);
					}
				});
				
		    }else{
		    	flag = 'unchecked';
		    	var inputs = $(this).parent().parent().next().find('input[type=\"checkbox\"]');
				$(inputs).each(function(index, val){
					$(val).prop(\"checked\", false);
					var id = $(val).attr('data-id');
					add_remove_item(flag,id);
				});
				
		    }


            return false;
		});

	", yii\web\View::POS_READY, "check_all");

?>


