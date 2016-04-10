<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;

	$this->title = $get_page_data->page_title.' | Model Test';

?>
<div class="container">
	<div class="row">
		<div class="inner_container">

			<div class="contactus-page-container margin-top-30">

				<div class="col-md-6">

					<div class="contactus_content">
						<h3>Contact us</h3>
						<div class="description">
							<?php echo $get_page_data->page_desc; ?>
						</div>


						<div class="contact_form_container">
							<h3>We really appreciate your feedbacks.</h3>

							<div class="form-container">

								<?php
                                    $form = ActiveForm::begin(
                                        [      
                                            'action' => Url::base().'/contactform/contactsubmit',                  
                                            'options' => [
                                                'class' => 'contact_submit'
                                            ]
                                        ]
                                    );
                                ?>

									<div class="col-md-12">
										<div class="row">
											<?= $form->field($contactus_model, 'name')->textInput(['maxlength' => 255]) ?>
										</div>
									</div>

									<div class="col-md-6 padding-left-0">
										<?= $form->field($contactus_model, 'email')->textInput(['maxlength' => 255]) ?>
									</div>

									<div class="col-md-6 padding-right-0">
										<?= $form->field($contactus_model, 'mobile')->textInput(['maxlength' => 11]) ?>
									</div>

								    <div class="col-md-12">
										<div class="row">
											<?= $form->field($contactus_model, 'subject')->textInput(['maxlength' => 255]) ?>
										</div>
									</div>

								    <div class="col-md-12">
										<div class="row">
											<?= $form->field($contactus_model, 'message')->textarea(['rows' => 6]) ?>
										</div>
									</div>

								    

								    <div style="float:left;">
									    <?= Html::submitButton($contactus_model->isNewRecord ? 'Send' : 'Update', ['class' => $contactus_model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
									</div>

								    <div class="contact_loader_images">								    	
										<div class="cssload-loader"></div>
								    </div>
								<?php ActiveForm::end(); ?>

							</div>
						</div>
					</div>

				</div>

				<div class="col-md-6">
					<div id="modeltestmaps" ></div>
				</div>


			</div>

		</div>
	</div>
</div>


<?php

	$this->registerJs("
        
        $(document).ready(
            
            $(document).delegate('.contact_submit', 'beforeSubmit', function(event, jqXHR, settings) {
                
                    var form = $(this);
                    if(form.find('.has-error').length) {
                            return false;
                    }

                    $('.contact_loader_images').show();
                    
                    $.ajax({
                            url: form.attr('action'),
                            type: 'post',
                            data: form.serialize(),
                            success: function(data) {
                                dt = jQuery.parseJSON(data);
                                $('.contact_loader_images').html(dt.message);
                                
                                setTimeout(function() {
                                    $('.contact_loader_images').html('');
                                }, 4000);
                            }
                    });
                    
                    return false;
            })


        );
    
    ", yii\web\View::POS_READY, "contact_submit");

?>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<script>
    var locations = [['Model Test','23.724265','90.379618','']];
    var change_count = 0;

    var latlngbounds = new google.maps.LatLngBounds();

    var map = new google.maps.Map(document.getElementById('modeltestmaps'), {
        zoom: 15,
        center: new google.maps.LatLng(23.724265,90.379618),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon: '<?= Url::base('') ?>/images/favicon.png'
        });

        latlngbounds.extend(new google.maps.LatLng(locations[i][1], locations[i][2]));

        google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
            return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
            }
        })(marker, i));

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                location.href = locations[i][3];
            }
        })(marker, i));

    }


</script>