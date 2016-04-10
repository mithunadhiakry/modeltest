<?php

	use yii\helpers\Url;
	use frontend\models\Category;
	use frontend\models\Subject;
	use frontend\models\Chapter;
	use frontend\models\Question;
	use frontend\models\Questionset;

?>

<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">																						
		<?php
			$sub_category = 1;
			
			if(isset($get_sub_category_r)){
				foreach($get_sub_category_r as $get_sub_category){
		?>
					<li role="presentation" class="<?php if($sub_category == 1)echo 'active'; ?>"><a href="#model_subcategory<?= $get_sub_category->id ?>" role="tab" data-toggle="tab"><?= $get_sub_category->category_name; ?></a></li>
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
	    	<div role="tabpanel" class="tab-pane <?php if($sub_category == 1)echo 'active'; ?>" id="model_subcategory<?= $get_sub_category->id ?>">
	    		
	    		<?php 
	    			if(isset($get_all_subject_r)){
	    				foreach($get_all_subject_r as $get_all_subject){
	    					$get_all_question_set_r = Questionset::find()->where(['like','subject_id',$get_all_subject->id])->andWhere(['status' => 1])->all();

	    					if(isset($get_all_question_set_r) && count($get_all_question_set_r) !=0){

	    		?>
							<div class="exam_selection_individual_sub_header"><?= $get_all_subject->subject_name; ?></div>
							
							<div class="exam_selection_checkbox">
								<div class="col-md-12">

									<?php
										foreach($get_all_question_set_r as $get_all_question_set){
											
									?>
												<div class="checkbox_container">
													<span class="chapter question_set" style="cursor:pointer;" data-id="<?= $get_all_question_set->question_set_id; ?>">
														<input type="radio" name="paid_exam">
														<?php
															if(isset(\Yii::$app->user->identity->user_type) && \Yii::$app->user->identity->user_type == 'student' && $get_all_question_set->created_by == \Yii::$app->user->identity->institution_id ):
																echo $get_all_question_set->question_set_name;
															else:
																echo $get_all_question_set->alternate_name?$get_all_question_set->alternate_name:$get_all_question_set->question_set_name;
															endif;
														?>
													
													</span>
												</div>
									<?php
											}
										
									?>
									
								</div>
							</div>
	    		<?php
	    					}
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