<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;
//echo Yii::$app->params['adminEmail'];
//echo Yii::$app->params['supportEmail'];
  
?>
<link href="<?=$this->theme->baseUrl;?>/vendor/plugins/form/icheck/skins/square/_all.css" rel="stylesheet">

<div class="col-md-12">

      <ul role="tablist" class="nav nav-tabs">
          <li role="presentation" class="active"><a data-toggle="tab" role="tab" aria-controls="exam" href="#exam" aria-expanded="false">Exam Settings</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="home" href="#home" aria-expanded="false">General Settings</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile" aria-expanded="true">Backend Themes</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="vat_tab" href="#vat_tab" aria-expanded="true">Vat</a></li>
          <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="negative_points" href="#exam_points" aria-expanded="true">Exam Points</a></li>
       </ul>

      <div class="tab-content" style="width:100%;float:left;">

          <div id="exam_points" class="tab-pane" role="tabpanel">
              

             <div class="col-md-6">
                <div class="form-group">
                   <label>Model Test (plus point)</label>
                   <input type="text" class="form-control" placeholder="" id="model_test_plus_points" value="<?= Yii::$app->params['model_test_plus_points']; ?>">
                </div>

                <div class="form-group">
                   <label>Practice Exam (plus point)</label>
                   <input type="text" class="form-control" placeholder="" id="practice_exam_plus_points" value="<?= Yii::$app->params['practice_exam_plus_points']; ?>">
                </div>

                 <div class="form-group">
                   <label>Previous Exam - Class XI-XII (plus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_class_xi_xii_plus_points" value="<?= Yii::$app->params['previous_exam_class_xi_xii_plus_points']; ?>">
                </div>

                <div class="form-group">
                   <label>Previous Exam - Admission (plus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_admission_plus_points" value="<?= Yii::$app->params['previous_exam_admission_plus_points']; ?>">
                </div>

                <div class="form-group">
                   <label>Previous Exam - Job (plus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_job_plus_points" value="<?= Yii::$app->params['previous_exam_job_plus_points']; ?>">
                </div>

             </div>

             <div class="col-md-6">
                <div class="form-group">
                   <label>Model Test (minus point)</label>
                   <input type="text" class="form-control" placeholder="" id="model_test_minus_points" value="<?= Yii::$app->params['model_test_minus_points']; ?>">
                </div>

                 <div class="form-group">
                   <label>Practice Exam (minus point)</label>
                   <input type="text" class="form-control" placeholder="" id="practice_exam_minus_points" value="<?= Yii::$app->params['practice_exam_minus_points']; ?>">
                </div>

                 <div class="form-group">
                   <label>Previous Exam - class XI-XII (minus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_class_xi_xii_minus_points" value="<?= Yii::$app->params['previous_exam_class_xi_xii_minus_points']; ?>">
                </div>

                <div class="form-group">
                   <label>Previous Exam - Admission (minus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_admission_minus_points" value="<?= Yii::$app->params['previous_exam_admission_minus_points']; ?>">
                </div>

                <div class="form-group">
                   <label>Previous Exam - Job (minus point)</label>
                   <input type="text" class="form-control" placeholder="" id="previous_exam_job_minus_points" value="<?= Yii::$app->params['previous_exam_job_minus_points']; ?>">
                </div>
             </div>
            
              
          </div>

          <div id="vat_tab" class="tab-pane" role="tabpanel">
             <div class="form-group">
                  <label>Vat</label>
                  <input type="text" class="form-control" placeholder="" id="vat" value="<?= Yii::$app->params['vat']; ?>">
              </div>
          </div>

          <div id="exam" class="tab-pane active" role="tabpanel">
            <div class="row">

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Point deductions</span></h2>

                      <div class="form-group">
                          <label>Class VIII - XII (Practice)</label>
                          <input type="text" class="form-control" placeholder="" id="Class_VIII_XII_Practice" value="<?= Yii::$app->params['Class_VIII_XII_Practice']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Others  (Practice)</label>
                          <input type="text" class="form-control" placeholder="" id="others_Practice" value="<?= Yii::$app->params['others_Practice']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Class VIII - XII (ModelTest)</label>
                          <input type="text" class="form-control" placeholder="" id="Class_VIII_XII_ModelTest" value="<?= Yii::$app->params['Class_VIII_XII_ModelTest']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Others (ModelTest)</label>
                          <input type="text" class="form-control" placeholder="" id="others_ModelTest" value="<?= Yii::$app->params['others_ModelTest']; ?>">
                      </div>

                    </div>
              </div>


            </div>
          </div>

          <div id="home" class="tab-pane" role="tabpanel">
            <div class="row">

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Mail Settings</span></h2>

                      <div class="form-group">
                          <label>Admin Email</label>
                          <input type="text" class="form-control" placeholder="Email" id="admin_email" value="<?= Yii::$app->params['adminEmail']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Contact Email</label>
                          <input type="text" class="form-control" placeholder="Email" id="contact_email" value="<?= Yii::$app->params['contact_email']; ?>">
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Header Settings</span></h2>

                      <div class="form-group">
                          <label>Site Title</label>
                          <textarea id="site_title" class="form-control"  maxlength="140"><?= Yii::$app->params['site_title']; ?> </textarea>
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Footer Settings</span></h2>

                      <div class="form-group">
                          <label>Copyright Text</label>
                          <textarea id="copyright_text" class="form-control"  maxlength="140"><?= Yii::$app->params['copyright_text']; ?> </textarea>
                      </div>

                    </div>
              </div>


              <div style="clear:both;"></div>

              <div class="col-md-4">
                    <div class="pane equal">
                      <h2><span>Social Settings</span></h2>

                      <div class="form-group">
                          <label>Facebook</label>
                          <input type="text" id="facebook" class="form-control" value="<?= Yii::$app->params['facebook']; ?>">
                      </div>

                      <div class="form-group">
                          <label>Twitter</label>
                          <input type="text" id="twitter" class="form-control" value="<?= Yii::$app->params['twitter']; ?>">
                      </div>

                      <div class="form-group">
                          <label>LinkedIn</label>
                          <input type="text" id="linkedin" class="form-control" value="<?= Yii::$app->params['linkedin']; ?>">
                      </div>

                    </div>
              </div>

              <div class="col-md-4">
                <div class="pane equal">
                  <h2><span>Editor Config</span></h2>

                    <?php 
                      foreach ($configs as $key => $value) {
                    ?>
                          
                          <div class="radio blue">
                              <label>
                                <input type="radio" id="editor" name="editor" value="<?= $value; ?>" <?php  if(Yii::$app->params['editor']==$value){echo 'checked';} ?> > <?php echo ucfirst($value); ?>
                              </label>
                          </div>

                    <?php
                      }
                    ?>
                    
                </div>
              </div>



            </div>
          </div>



          <div id="profile" class="tab-pane" role="tabpanel">
                <div class="row">
                  
                  <?php
                    foreach ($themes_array as $value) {
                      
                  ?>

                    <div class="col-md-4 <?php echo ($value['name']==Yii::$app->params['backend.theme'])?'theme_active':'';  ?>">
                      <div class="pane equal">
                        <div class="theme_box">
                          <div class="theme_img">
                            <img src="<?= $value['image']; ?>">
                          </div>
                          <div class="theme_name">
                            <?= $value['name']; ?>
                          </div>
                          <div class="activate">
                            <a href="#" type="back" data="<?= $value['name']; ?>">Activate</a>
                          </div>

                          <div class="active">
                            Active
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                    }
                  ?>

                </div>
          </div>



      </div>
</div>


<div class="col-md-12">
      <div class="form-group">
          <div class="col-lg-12" style="margin:10px 0;">
            <input type="button" class="btn btn-sm btn-primary save_settings_btn pull-right" value="Save Settings">
          </div>
      </div>
</div>


<div class="settings-index">

</div>

<?php
  $this->registerJs("
                    $(document).delegate('.activate a', 'click', function() { 
                        var name = $(this).attr('data');
                        var type = $(this).attr('type');

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('settings/activate_theme')."',
                            data: {name:name,type:type,_csrf: yii.getCsrfToken()},
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                      location.reload();
                                     }else{
                                      alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'activate_theme');


  $this->registerJs("
                    $(document).delegate('.save_settings_btn', 'click', function() { 
                        var admin_email = $('#admin_email').val();
                        var contact_email = $('#contact_email').val();
                        var copyright_text = $('#copyright_text').val();
                        var site_title = $('#site_title').val();
                        var facebook = $('#facebook').val();
                        var twitter = $('#twitter').val();
                        var linkedin = $('#linkedin').val();
                        var editor = $('#editor').val();

                        var Class_VIII_XII_Practice = $('#Class_VIII_XII_Practice').val();
                        var others_Practice = $('#others_Practice').val();
                        var Class_VIII_XII_ModelTest = $('#Class_VIII_XII_ModelTest').val();
                        var others_ModelTest = $('#others_ModelTest').val();

                        var vat = $('#vat').val();

                        var model_test_plus_points = $('#model_test_plus_points').val();
                        var previous_exam_class_xi_xii_plus_points = $('#previous_exam_class_xi_xii_plus_points').val();
                        var practice_exam_plus_points = $('#practice_exam_plus_points').val();
                        var model_test_minus_points = $('#model_test_minus_points').val();
                        var previous_exam_class_xi_xii_minus_points = $('#previous_exam_class_xi_xii_minus_points').val();
                        var practice_exam_minus_points = $('#practice_exam_minus_points').val();
                        var previous_exam_admission_plus_points = $('#previous_exam_admission_plus_points').val();
                        var previous_exam_admission_minus_points = $('#previous_exam_admission_minus_points').val();
                        var previous_exam_job_plus_points = $('#previous_exam_job_plus_points').val();
                        var previous_exam_job_minus_points = $('#previous_exam_job_minus_points').val();

                        $.ajax({
                            type : 'POST',
                            dataType : 'json',
                            url : '".Url::toRoute('settings/save_settings')."',
                            data: {
                                  admin_email:admin_email,
                                  contact_email:contact_email,
                                  copyright_text:copyright_text,
                                  site_title:site_title,
                                  facebook:facebook,
                                  twitter:twitter,
                                  linkedin:linkedin,
                                  editor:editor,
                                  Class_VIII_XII_Practice:Class_VIII_XII_Practice,
                                  others_Practice:others_Practice,
                                  Class_VIII_XII_ModelTest:Class_VIII_XII_ModelTest,
                                  others_ModelTest:others_ModelTest,
                                  vat:vat,
                                  model_test_plus_points:model_test_plus_points,
                                  previous_exam_class_xi_xii_plus_points:previous_exam_class_xi_xii_plus_points,
                                  practice_exam_plus_points:practice_exam_plus_points,
                                  model_test_minus_points:model_test_minus_points,
                                  previous_exam_class_xi_xii_minus_points:previous_exam_class_xi_xii_minus_points,
                                  practice_exam_minus_points:practice_exam_minus_points,
                                  previous_exam_admission_plus_points:previous_exam_admission_plus_points,
                                  previous_exam_admission_minus_points:previous_exam_admission_minus_points,
                                  previous_exam_job_plus_points:previous_exam_job_plus_points,
                                  previous_exam_job_minus_points:previous_exam_job_minus_points
                            },
                            beforeSend : function( request ){},
                            success : function( data )
                                { 
                                     if(data.result == 'success'){
                                      location.reload();
                                     }else{
                                      alertify.log(data.msg, 'error', 5000);
                                     }
                                }
                        });
                        return false;
                    });
    ", yii\web\View::POS_READY, 'save_settings_btn');


    $this->registerJsFile($this->theme->baseUrl."/vendor/plugins/form/icheck/icheck.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
    $this->registerJs("
                    $('.blue input').iCheck({
                          radioClass: 'iradio_square-blue',
                      });
    ", yii\web\View::POS_READY, 'register_radios');
?>
