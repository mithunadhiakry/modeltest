<?php

	use yii\helpers\Url;
	use frontend\models\Category;
	use frontend\models\Subject;
	use frontend\models\Chapter;
	use frontend\models\Question;
?>

<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">																						
		<?php
			$sub_category = 1;
			
			$get_sub_category_r = Category::get_sub_category($category_list->id);
			if(isset($get_sub_category_r)){
				foreach($get_sub_category_r as $get_sub_category){
		?>
					<li role="presentation" class="<?php if($sub_category == 1)echo 'active'; ?>"><a href="#subcategory<?= $get_sub_category->id ?>" role="tab" data-toggle="tab"><?= $get_sub_category->category_name; ?></a></li>
		<?php
					$sub_category++;
				}
			}
		?>
	    
	</ul>

	  <!-- Tab panes -->
	<div class="tab-content">
	  	<?php
	  		$sub_category = 1;
  			if(isset($get_sub_category_r)){
				foreach($get_sub_category_r as $get_sub_category){
					$get_all_subject_r = Subject::get_all_subject_list($get_sub_category->id);
	  				
	  	?>
	    	<div role="tabpanel" class="tab-pane <?php if($sub_category == 1)echo 'active'; ?>" id="subcategory<?= $get_sub_category->id ?>">
	    		
	    		<?php 
	    			$count = 1;
	    			if(isset($get_all_subject_r)){
	    				foreach($get_all_subject_r as $get_all_subject){
	    					$get_all_chapter_r = Chapter::get_all_chapter_list($get_all_subject->id);
	    		?>
							<div class="exam_selection_individual_sub_header"  >
								<a class="examcencer_with_suject " role="button" data-toggle="collapse" data-parent="#accordion" href="#examcenter_subject<?= $get_all_subject->id;?>" aria-expanded="true">
									<span class="examcenter_subject"><?= $get_all_subject->subject_name; ?> (<?=count($get_all_chapter_r);?>)</span>
									<span class="examcenter_withsubject_active <?php if($count == 1){echo 'active';} ?>">&nbsp;</span>
								</a>
								
								<?php
									if($get_all_subject->category_id == '56'){
								?>
									<span class="select_all">
										<span class="style_text">Select all</span>
										<input type="checkbox" class="exam_selection_checkbox" name="select_all">
									</span>
								<?php
									}
								?>
							</div>
							
							<div id="examcenter_subject<?= $get_all_subject->id;?>" class="exam_selection_checkbox panel-collapse collapse <?php if($count == 1){echo 'in';} ?>" role="tabpanel" >
								<div class="col-md-12">

									<?php
										if(isset($get_all_chapter_r)){

											

											foreach($get_all_chapter_r as $get_all_chapter){
												$get_number_of_question = Question::get_numberof_question($get_all_chapter->id); 

												if(in_array($get_all_chapter->id,$chapter_list_session)){
							                        $flag = 1;
							                    }else{
							                    	$flag = 0;
							                    }
									?>
												<div class="checkbox_container">
													<?php
														if($category_list->id == 59){
													?>
															<span class="chapter previous_year_question_set" style="cursor:pointer;" data-id="<?= $get_all_chapter->id; ?>">
																<input type="radio" name="paid_exam">
																<?= $get_all_chapter->chaper_name; ?>
															</span>

													<?php }else{ ?>

															<input data-id="<?= $get_all_chapter->id; ?>" <?= ($flag == 1)?'checked="checked"':'' ?> type="checkbox" name="exam_selection" class="exam_selection_checkbox selection_checkbox_<?= $get_all_chapter->id; ?>">
															<span class="chapter"><?= $get_all_chapter->chaper_name; ?> <span class="number">( <?=$get_number_of_question;?> )</span></span>

													<?php	}

													?>
													
												</div>
									<?php
											}
										}
									?>
									
								</div>
							</div>
	    		<?php
	    			$count++;
	    				}

	    			}
	    		?>
				
			</div>
	  	<?php
	  			$sub_category++;
	  			}
	  		}
	  	?>
	</div>


	<?php

		$this->registerJs("

			$('.examcencer_with_suject').click(function(e) {
		        e.preventDefault();
		        if(!$(this).find('.examcenter_withsubject_active').hasClass('active')) {
		           
		            $(this).find('.examcenter_withsubject_active').addClass('active');
		        } else {
		            $(this).find('.examcenter_withsubject_active').removeClass('active');		            
		        }
		    });

		", yii\web\View::POS_READY, "add_class_according");

	?>
	