<?php
	use yii\helpers\Html;
	use yii\helpers\Url;

	$this->title = 'My Exam | Model Test';
?>

<div class="container">
	<div class="row">
		<div class="inner_container">
			
			<div class="ac_point account_ac_point">
		    	<h3>History</h3>
	    	</div>	

	    	<div class="points_history_table col-md-12">
	    		<div class="row">
					<table class="table table-striped table-bordered activity_table">
						<thead>
							<tr>
								<th>Exam Sunject/Course</th>
								<th>Exam type</th>
								<th>Assign by</th>
								<th>Time & date to assign</th>
								<th>Exam status</th>
								<th>Report</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$temp_date = date('Y-m-d', strtotime('tomorrow'));
								foreach($exams as $get_activity_log){
							?>
									<?php
										if($temp_date != date_format(date_create($get_activity_log->created_at), 'Y-m-d')){
									?>
									<tr>
										<td colspan="6" class="text-align-center">
											<?php
												$attended_date = $get_activity_log->created_at;
											    if (strtotime($attended_date) >= strtotime("today")){
											    	echo "Today";
											    }else if(strtotime($attended_date) >= strtotime("yesterday")){
											    	echo "Yesterday";
											    }else{
											    	echo date('Y-m-d', strtotime($attended_date));
											    }
											        
											?>
										</td>
									</tr>
									<?php
										}
									?>
							
									<tr>
										<td>
											<?php
												if($get_activity_log->question_set_id == '0'){
													echo 'General Test';
												}
												elseif($get_activity_log->question_set_id == '1'){
													echo 'Previous Year';
												}else{
													echo $get_activity_log->questionset->question_set_name;
												}
											?>
										</td>
										<td>
											<?php
												if($get_activity_log->question_set_id == '0'){
													echo 'General Test';
												}
												elseif($get_activity_log->question_set_id == '1'){
													echo 'Previous Year';
												}else{
													echo 'Model Test';
												}
											?>
										</td>
										<td>
											<?php
												if($get_activity_log->assign_by == $user_id){
													echo 'MySelf';
												}else{
													echo $get_activity_log->assignbyUser->name;
												}
											?>
										</td>
										<td>
											<?php
												
												echo $get_activity_log->created_at;
											?>
										</td>
										<td>Completed</td>
										<td><a class="view" href="<?= Url::toRoute(['exam/report/'.$get_activity_log->exam_id]); ?>">View</td>
									</tr>
							<?php
										
									$temp_date = date_format(date_create($get_activity_log->created_at), 'Y-m-d');
								}
							?>
							
							
							
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-12">
    			<div class="row">
    				<?php if(count($exams) > 9): ?>
    					<a href="<?= Url::toRoute(['user/load_more_activity']); ?>" data-offset="10" class="btn btn-sm btn-primary load_more_activity floatright">Load more</a>
    				<?php endif; ?>
    			</div>
    			<div class="load_more_loader">
	    			<div class="css_loader_container_wrap">
						<div class="css_loader_container">
							<div class="cssload-loader"></div>
						</div>
					</div>
				</div>
    		</div>


		</div>
	</div>
</div>

<?php
	$this->registerJs("
		
		$('.load_more_activity').on('click',function (e) {
			var offset = $(this).attr('data-offset');
			var url = $(this).attr('href');
			
			get_more_data('activity',url,offset,'.load_more_activity','.activity_table tbody');

            return false;
		});

		function get_more_data(type,url,offset,class_name,table_name){
			$.ajax({
		        type : 'POST',
	            dataType : 'json',
	            url : url,
	            data: {type:type,offset:offset},
	            beforeSend : function( request ){
	            	$(class_name).parent().next().find('.css_loader_container_wrap').fadeIn();
	            },
	            success : function( data )
	                { 
	                $(class_name).parent().next().find('.css_loader_container_wrap').fadeOut();

	                	if(data.result == 'success'){
	                		var new_offset = parseInt(offset)+10;
		                	$(class_name).attr('data-offset',new_offset);
		                	$(table_name).append(data.msg);
		                	if(data.item_count == '0'){
		                		$(class_name).hide();
		                	}
		                }
	                    else if(data.result == 'error'){
	                    	//window.location = data.redirect_url;
	                    }
	                }
	        });
		}

	", yii\web\View::POS_READY, "load_more");

?>