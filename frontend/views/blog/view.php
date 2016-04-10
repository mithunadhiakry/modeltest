<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use frontend\models\BlogComments;
	use yii\widgets\ActiveForm;
	use frontend\models\User;

	$blogcomments_modal = new BlogComments();

	$this->title = "Articles | Model Test";

	if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student'){
	    $user_id = Yii::$app->user->identity->id;
	    $user_data = User::find()
	                ->where(['id' => $user_id])
	                ->one();
	}
?>
<script type="text/javascript" src="<?php echo Url::base()."/ckeditor/ckeditor.js"; ?>"></script>
<div class="container">
	<div class="row">
		<div class="inner_container">
			<div class="inner_common_page margin-top-30">
				<h3 class="blogs-details"><?= $model->name; ?></h3>
				<div class="blog-author">
					<a href="#">
                        <span class="blog-authorName">
                            <?php
                                    echo $model->author_name->name;
                            ?>
                        </span>
                    </a>
                    <span class="blog-postingDate">
                        <?= date_format(date_create($model->created_at), 'jS F\, Y h:i A'); ?>                                        
                    </span>

                    <span class="blog-postingDate">
                      Views ( <?= $model->count;?> )
                        
                    </span>

                    <span class="blog-postingDate">
                        Comment (
                          <?php

                            $blog_comments_data_count = BlogComments::find()
                              ->where(['blog_id' => $model->id])
                               ->count(); 
                            echo $blog_comments_data_count;
                          ?>
                        )                                                                              
                    </span>
				</div>

				<div class="blog-comment ">
					<?= $model->description; ?>
				</div>


				<div class="blog-comments-container margin-top-30">
					<h3 class="blog-comments">Comments:</h3>
					<div class="blog-commentBox">

						<?php
                            $form = ActiveForm::begin(
                                [   
                                    'action' => Url::base().'/blogcomments/add_comments',                                                                 
                                    'options' => [
                                        'class' => 'add_comments_data'
                                    ]
                                ]
                            );
                        ?>
							
							<div class="blog-user">
								<?php
                                    if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student' ){
                                ?>
										<img src="<?= Url::base('') ?>/user_img/<?= $user_data->image; ?>">
                                <?php  }else{ ?>

									<img src="<?= Url::base('') ?>/images/avater.png">

                                <?php } ?>
                            	
                            </div>
                            <div class="blog-userCommentBox">
								<?= $form->field($blogcomments_modal, 'comments')->textArea(['rows' => '6','id'=>'editor_blog_comments'])->label(false); ?>

								<div class="form-group">
									<?php
	                                    if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->user_type == 'student' ){
	                                ?>
	                                		<input type="hidden" name="BlogComments[user_id]" value="<?= $user_data->id; ?>">
	                                		<input type="hidden" name="BlogComments[blog_id]" value="<?= $model->id; ?>">
	                                		<span class="blog_insert_success" style="color:green;"></span>
											<?= Html::submitButton($blogcomments_modal->isNewRecord ? 'Comment' : 'Comment', ['class' => $model->isNewRecord ? 'btn btn-success floatright' : 'floatright btn btn-primary']) ?>
	                                <?php } ?>
	                                
	                            </div>
                            </div>


						<?php ActiveForm::end(); ?>
						
						<div class="blog_comments_by_blog">
							<?php
								if(!empty($blog_comments_data)){
									foreach($blog_comments_data as $blog_comments){
							?>
										<div class="blog-commentSection">

				                            <div class="blog-blogCommentUserImage">
				                            	<?php
				                            		if(!empty($blog_comments->author_name->image)){
				                            	?>
														<img src="<?= Url::base('') ?>/user_img/<?= $blog_comments->author_name->image; ?>">
				                            	<?php
				                            		}else{
				                            	?>
														<img src="<?= Url::base('') ?>/images/avater.png">
				
				                            	<?php
				                            		}

				                            	?>
				                            </div>
				                            <div class="blog-blogCommentDescription">
				                               <span class="blog-authorName">
													<?= $blog_comments->author_name->name;	?>
				                               </span>
				                                <span class="blog-postingDate">
				                                	<?= date_format(date_create($blog_comments->time), 'jS F\, Y h:i A'); ?>                                        
				                                </span>
				                            	<div class="blog-usersComment">
					                                <?= $blog_comments->comments; ?>
					                            </div>
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
</div>

<?php

   

    $this->registerJs("
    
        $(document).ready(
            $(document).delegate('.add_comments_data', 'beforeSubmit', function(event, jqXHR, settings) {
                
                    var form = $(this);
                    if(form.find('.has-error').length) {
                            return false;
                    }
                    
                    $.ajax({
                            url: form.attr('action'),
                            type: 'post',
                            data: form.serialize(),
                            success: function(data) {
                                dt = jQuery.parseJSON(data);
                                
                                $('.blog_insert_success').html('Thank you for comment.');
                                $('.blog_comments_by_blog').append(dt.comments);
                                
                               
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "send_comments_in_blog");

?>