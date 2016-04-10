<?php
	
	use yii\helpers\Url;

	$this->title ='Exam Centre | Model Test';
?>
<!-- Start of exam center -->
		
		<div class="container">
			<div class="row">
				<div class="exam_container">
					<div class="header">
						Exam
						<span class="instruction">
							<a href="#" data-toggle="modal" data-target="#instruction_model"><i class="fa fa-info"></i></a>
						</span>
						<!-- Button trigger modal -->
						
						<div class="modal fade" id="instruction_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
						    <div class="modal-dialog modal-lg">
						        <div class="modal-content">
						        
						        <div class="modal-header instruction_model">
						            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						            <h4 class="modal-title" id="myModalLabel1">Instructions</h4>
						        </div><!-- /modal-header -->
						        
						        <div class="modal-body instruction_model">
						     		<?php                           
						                if(!empty($get_page_data->post)){
						                    foreach($get_page_data->post as $post_data){
						                        echo $post_data->desc;
						                    }
						                }
						            ?>
						        </div><!-- /modal-body -->
						        
						        <div class="modal-footer text-right">
						        	<div class="start_exam_loader">
						        		<div class="css_loader_container_wrap">
											<div class="css_loader_container">
												<div class="cssload-loader"></div>
											</div>
										</div>
						        	</div>
						        	
						            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						        </div><!-- /modal-footer -->
						        
						        </div><!-- /modal-content -->
						    </div><!-- /modal-dialog -->
						</div><!-- /modal -->
						
					</div>

					<!-- <div class="my_selected_list">
						
					</div> -->

					<div class="exam_list_container">
						<div class="col-md-9">
							<div class="question-list-container">

								

								<div class="question-list ">
									<div class="question-full">
										<div class="question-no">
											<div class="question_number">Question <?= $question->serial; ?> | </div>
										</div>
										<div class="questions_of_year"><?= $question->question->questions_of_year; ?></div>
										<div class="question-name">
											<?= $question->question->details; ?>
										</div>
									</div>

									<div class="anwer-list">
										<div class="answer-header">Answer</div>
										<?php
											foreach ($question->question->answer as $key) {
										?>

											<div class="answer-row">
												<input type="radio" class="answer_radio" name="answer_radio" value="<?= $key->id; ?>">
												<span>
													<?= $key->answer; ?>
												</span>
											</div>

										<?php
											}
										?>

									</div>
								</div>

								<div class="left_arrow">
									<a href="#">
										<img src="<?= Url::base('') ?>/css/images/arrow.png">
									</a>
								</div>
								
								<div class="right_arrow">
									<a href="#">
										<img src="<?= Url::base('') ?>/css/images/arrow.png">
									</a>
								</div>

							</div>

							<div class="css_loader_container_wrap">
								<div class="css_loader_container">
									<div class="cssload-loader"></div>
								</div>
							</div>

							<div class="col-md-12 padding-left-0 border-right ">
								<div class="question_submit_container">
									<a class="mark_for_review_btn" href="#" class="active">Mark for review</a>
									<a class="skip_btn" href="#">Skip</a>	
									<a class="save_and_next_btn" href="#">Save & Next</a>
								</div>
							</div>


						</div>
						<div class="col-md-3 padding-right-30">
							<div class="exam_timer_container">
								<!-- <div class="icon">
									<i class="fa fa-clock-o"></i>
								</div> -->
								
								<div id="countdowntimer">
									<div class="time_count">
										
									</div>
								</div>
								<button id="pauseBtnhms" value="pause" style="display:none;">Pause</button>
							</div>

							<div class="question_of_subject">
								
							</div>
							
							<div class="exam_list_icon">
								<div class="exam_list_circle">
									<?php
										foreach ($question_list as $question_item) {
											$item_class='';
											if($question_item->is_correct == 0 && $question_item->mark_for_review == 0){
												$item_class = 'circle';
											}elseif($question_item->is_correct != 0 && $question_item->mark_for_review == 1){
												$item_class = 'circle marked';
											}elseif($question_item->is_correct != 0 && $question_item->mark_for_review != 1){
												$item_class = 'circle answer';
											}
									?>

										<a href="#" data-item-id="<?= $question_item['serial']; ?>" id="q_<?= $question_item->serial.$question_item->question_id; ?>" class="<?= $item_class; ?>"><?= $question_item->serial; ?></a>

									<?php
										}
									?>
									
								</div>

								<div class="hints_container">
									<div class="hints_content">
										<span class="blank_box answer">&nbsp;</span>
										<span class="legend_hints">Anwersed</span>
									</div>

									<div class="hints_content">
										<span class="blank_box marked">&nbsp;</span>
										<span class="legend_hints">Marked</span>
									</div>

									<div class="hints_content">
										<span class="blank_box">&nbsp;</span>
										<span class="legend_hints">Not answer</span>
									</div>
								</div>

								<input type="submit" name="" value="SUBMIT" class="submit_exam_center">
								
							</div>
						</div>
					</div>
					
					

				</div>
			</div>
		</div>


<?php
	
	$this->registerJs("

		var hours = '".$exam_time_hours."';          
    	var minutes = '".$exam_time_mins."';         
    	var seconds = '".$exam_time_secs."';
    	var until = '+'+hours+'h +'+minutes+'m +'+seconds+'s';
    	
		$('#countdowntimer div').countdown({ 
	       until: until,
	       compact: true,
	       format: 'HMS',
	       onExpiry: liftOff
	    });

		function liftOff() { 
		    $('.submit_exam_center').click(); 
		}

		$(document).delegate('.mark_for_review_btn','click',function(){
			if($('.answer_radio').is(':checked')){
				val = parseInt($('input[name=answer_radio]:radio:checked').val());
			 	answer_action('mark_review',val);
			}else{

				BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': 'You have to select a answer'
								});
			}

			return false;
		})

		$(document).delegate('.skip_btn','click',function(){
			val = parseInt($('input[name=answer_radio]:radio:checked').val());
			answer_action('skip','0');

			return false;
		})

		$(document).delegate('.save_and_next_btn','click',function(){
			if($('.answer_radio').is(':checked')){
			 	val = parseInt($('input[name=answer_radio]:radio:checked').val());
			 	answer_action('save_and_next',val);
			}else{
				
				BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': 'You have to select a answer'
								});
			}

			return false;
		})

		$('.right_arrow a').on('click',function(){
			val = parseInt($('input[name=answer_radio]:radio:checked').val());

			answer_action('skip','0');

			return false;
		});

		$('.left_arrow a').on('click',function(){
			val = parseInt($('input[name=answer_radio]:radio:checked').val());
			answer_action('prev','0');

			return false;
		});

		var is_review_shown = 0;
		var is_skip_shown = 0;
		function answer_action(type,val){
			$.ajax({
	            type : 'POST',
	            dataType : 'json',
	            url : '".Url::toRoute('rest/save_answer')."',
	            data: {type:type,val:val},
	            beforeSend : function( request ){
	            	$('.css_loader_container_wrap').fadeIn();
	            	//$('#countdowntimer div').countdown('pause');
	            },
	            success : function( data )
	                {   

	                	$('.css_loader_container_wrap').fadeOut();
	                	if(data.result == 'success'){
	                		if(data.status != 'Completed'){
	                			if(data.is_review == 'yes'){
	                				if(is_review_shown == 0){
	                					BootstrapDialog.confirm({
						                    title: 'WARNING',
						                    message: 'Do you want to answer \"Marked Review\" questions?',
						                    type: BootstrapDialog.TYPE_WARNING,
						                    closable: false,
						                    draggable: true,
						                    btnCancelLabel: 'No!',
						                    btnOKLabel: 'Yes!',
						                    callback: function(result) {
						                        if(result) {
						                            return true;
						                        }else {
						                            $('.submit_exam_center').click();
						                            return false;
						                        }
						                    }
						                });
	                					is_review_shown = 1;
	                				}
	                			}
	                			if(data.is_skip == 'yes'){
	                				if(is_skip_shown == 0){
	                					BootstrapDialog.confirm({
						                    title: 'WARNING',
						                    message: 'Do you want to answer \"Skiped\" questions?',
						                    type: BootstrapDialog.TYPE_WARNING,
						                    closable: false,
						                    draggable: true,
						                    btnCancelLabel: 'No!',
						                    btnOKLabel: 'Yes!',
						                    callback: function(result) {
						                        if(result) {
						                            return true;
						                        }else {

						                        	if(data.is_review_exist == 'yes' ){

						                        		if(data.is_review_exist == 'yes'){
	                				
							                				BootstrapDialog.confirm({
												                    title: 'WARNING',
												                    message: 'Do you want to answer \"Marked Review\" questions?',
												                    type: BootstrapDialog.TYPE_WARNING,
												                    closable: false,
												                    draggable: true,
												                    btnCancelLabel: 'No!',
												                    btnOKLabel: 'Yes!',
												                    callback: function(result) {
												                        if(result) {
												                        	var maked_question_id= $('.exam_list_icon .marked').first().attr('data-item-id');
												                        	answer_specific_question(maked_question_id);
												                            return true;
												                        }else {
												                            $('.submit_exam_center').click();
												                            return false;
												                        }
												                    }
												                });

							                			}

						                        	}else{

						                        		$('.submit_exam_center').click();
						                            	return false;

						                        	}
						                            
						                        }
						                    }
						                });
	                					is_skip_shown = 1;
	                				}
	                			}


		                		$('.my_selected_list a').removeClass('active');
			                	$('#chapter_item_'+data.chapter_id).addClass('active');
			                	$('.question-list').html(data.message);

			                	$('#'+data.selected_result.item_id).addClass(data.selected_result.item_class);
			                
			                	var until = '+'+data.h+'h +'+data.m+'m +'+data.s+'s';
    							
    							$('#countdowntimer div').countdown('destroy');
								$('#countdowntimer div').countdown({ 
							       until: until,
							       compact: true,
							       format: 'HMS',
	       						   onExpiry: liftOff
							    });

			                }else{
			                	
			                	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.status
								});
			                }
		                }else{
		                	
		                	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                }
	                    
	                }
	        });
		}



		// $('.exam_list_circle a').on('click',function(){
		// 	val = parseInt($(this).attr('data-item-id'));
		// 	answer_specific_question(val);
		// 	return false;
		// });


		function answer_specific_question(val){
			$.ajax({
	            type : 'POST',
	            dataType : 'json',
	            url : '".Url::toRoute('rest/get_specific_question')."',
	            data: {val:val},
	            beforeSend : function( request ){
	            	//$('#countdowntimer div').countdown('pause');
	            	$('.css_loader_container_wrap').fadeIn();
	            },
	            success : function( data )
	                {   
	                	$('.css_loader_container_wrap').fadeOut();
	                	if(data.result == 'success'){
	                		if(data.status != 'Completed'){
		                		$('.my_selected_list a').removeClass('active');
			                	$('#chapter_item_'+data.chapter_id).addClass('active');
			                	$('.question-list').html(data.message);

			                	
			                	var until = '+'+data.h+'h +'+data.m+'m +'+data.s+'s';
    							
    							$('#countdowntimer div').countdown('destroy');
								$('#countdowntimer div').countdown({ 
							       until: until,
							       compact: true,
							       format: 'HMS',
	       						   onExpiry: liftOff
							    });
console.log(until);
			                }else{
			                	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.status
								});
			                }
		                }else{
		                	
		                	BootstrapDialog.alert({
									 title: 'WARNING',
									 'message': data.message
								});
		                }
	                    
	                }
	        });
		}

 	", yii\web\View::POS_READY, 'action_btns');



	$this->registerJs("

		$(document).delegate('.submit_exam_center','click',function(){
			var url = '".Url::toRoute(['exam/report','exam_id'=>$exam_id])."';

			window.location = url;

			return false;
		})

 	", yii\web\View::POS_READY, 'submit_exam_center');


    $this->registerJs("

		$(document).ready(function () {

			var my_selected_list_width = parseInt($( '.my_selected_list' ).width());
			var number_of_a = parseInt($( '.my_selected_list a' ).length);
			
			var get_width = (my_selected_list_width / number_of_a);

			$('.exam_container .my_selected_list a').css({
				'width':get_width
			});

		});

 	", yii\web\View::POS_READY, 'question_wheeling');

 	$this->registerJs("

 		var mouse_position_switch = false;

		$(document.body).on('mouseleave', function(e) {
		    
		    if(mouse_position_switch){
		        BootstrapDialog.confirm({
                    title: 'WARNING',
                    message: 'If you leave this window, your exam will not be saved. Do you want to leave?',
                    type: BootstrapDialog.TYPE_WARNING,
                    closable: false,
                    draggable: true,
                    btnCancelLabel: 'No!',
                    btnOKLabel: 'Yes!',
                    callback: function(result) {
                        if(result) {
                            var url = '".Url::toRoute(['exam/report','exam_id'=>$exam_id])."';
							window.location = url;
                        }else {
                            return false;
                        }
                    }
                });
		    }
		});

		$(document.body).on('mousemove', function(e) {
		    if(e.clientY < 100){
		        mouse_position_switch = true;
		    }else{
		        mouse_position_switch = false;
		    } 
		});

 	", yii\web\View::POS_READY, 'before_unload');
?>
 	<!-- end of exam center -->