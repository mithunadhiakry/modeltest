<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
      <meta charset="<?= Yii::$app->charset ?>"/>
      <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <?= Html::csrfMetaTags(); ?>
      
      <title><?= Html::encode($this->title) ?></title>

      <?php $this->head() ?>
      <?= $this->registerCssFile(Url::base()."/css/bootstrap-datetimepicker.min.css", ['media' => 'all',], 'bootstrap-datepicker'); ?> 
      <?php 
          $this->registerJsFile(Url::base()."/files/alertify.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
          $this->registerCssFile(Url::base()."/css/alertify.core.css", [
              'media' => 'all',
          ], 'css-alertify-core');

          $this->registerCssFile(Url::base()."/css/alertify.bootstrap.css", [
              'media' => 'all',
          ], 'css-alertify-default');


      ?>

      <?php
        $this->registerJsFile($this->theme->baseUrl."/vendor/js/required.min.all.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/quarca.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/bootstrap-dialog.min.js", ['depends' => [\yii\web\JqueryAsset::className()]]); 
        $this->registerJsFile($this->theme->baseUrl."/assets/js/jquery.maskedinput.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
      ?>
      <?= $this->registerJsFile($this->theme->baseUrl."/assets/js/bootstrap-datepicker.js", ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
      <!-- Styling -->
      <link href="<?php echo $this->theme->baseUrl; ?>/vendor/bootstrap/bootstrap.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/datepicker.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/style.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/dashboard-new.css" rel="stylesheet">
      <link href="<?php echo $this->theme->baseUrl; ?>/assets/css/ui.css" rel="stylesheet">
      
      <!-- Theme -->
      <link id="theme" href="<?php echo $this->theme->baseUrl; ?>/assets/css/themes/theme-default.css" rel="stylesheet" type="text/css">
      
      <!-- Fonts -->
      <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'> -->
      <link href="<?php echo $this->theme->baseUrl; ?>/vendor/fonts/font-awesome.min.css" rel="stylesheet">

</head>
    
<body>

  <div id="preloader"><div id="status">&nbsp;</div></div>
  
  <div class="wrapper dashboard">

  <!-- HEADER -->
      <header class="header affix" role="banner">
        <nav class="header-navbar">
            <div class="navbar-header clearfix">
                <a class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mini-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-plus"></i>
                </a>
                
                <a class="logo pull-left" href="<?= Url::toRoute(['/site/index']); ?>">
                    <?= Yii::$app->params['site_title']; ?>
                </a>
                
                <a class="sidebar-switch pull-right"><span class="icon fa"></span></a>
            </div>
        
            <div class="collapse navbar-collapse" id="mini-navbar-collapse">
                

          
                <ul class="nav navbar-nav navbar-right">
                    
                    <li><a href="<?= Url::toRoute(['/discounts/index']); ?>">
                        <i class="fa fa-credit-card"></i>
                        <span>Discounts</span>
                    </a></li> 
                     <li><a href="<?= Url::toRoute(['/membershiprequest/all_user']); ?>">
                        <i class="fa fa-credit-card"></i>
                        <span>User Panel</span>
                    </a></li> 
                    <li><a href="<?= Url::toRoute(['/settings/index']); ?>">
                        <i class="fa fa-wrench"></i>
                        <span>Settings</span>
                    </a></li>                    
                    <li class="turn-off"><a href="<?= Url::toRoute(['/site/logout']); ?>" data-method="post">
                        <i class="fa fa-power-off"></i>
                        <span>Log Out</span>
                    </a></li>
                </ul>
            </div><!-- navbar-collapse -->
        </nav>
      </header>
  <!-- HEADER -->

  <!-- SIDEBAR -->
  <aside class="sidebar affix" role="complementary">
    
    <div class="sidebar-container">
        <div class="sidebar-scrollpane">
          <div class="sidebar-content">
              
              <div class="sidebar-profile clearfix">
                  <a href="#" class="pull-left">
                      <figure class="profile-picture">
                          <img src="<?php echo Url::base(); ?>/user_img/<?php echo \Yii::$app->user->identity->image; ?>" alt="User Picture">
                      </figure>
                  </a>
                  <h6>Welcome,</h6>
                  <h5><?= \Yii::$app->user->identity->username;  ?></h5>
                  <div class="btn-group">
                      <a data-toggle="dropdown">
                        <span>
                            <!-- Last Access: <span class="online"><?= date_format(date_create(\Yii::$app->session->get('user.last_access')), "F j, Y, g:i a"); ?></span> -->
                        </span>
                      </a>
                      <ul class="dropdown-menu default" role="menu">
                        <li><a data-status="online"><span class="label label-status label-online">&nbsp;</span> Online</a></li>
                        <li><a data-status="busy"><span class="label label-status label-busy">&nbsp;</span> Busy</a></li>
                        <li><a data-status="away"><span class="label label-status label-away">&nbsp;</span> Away</a></li>
                        <li><a data-status="offline"><span class="label label-status label-offline">&nbsp;</span> Offline</a></li>
                      </ul>
                  </div>
              </div><!-- sidebar-profile -->
              
              <div role="tabpanel">
            <!-- Nav tabs -->
                  <ul class="tab-nav" role="tablist">

                      <li role="presentation" class="active" >
                        <a href="#nav2" aria-controls="nav" role="tab" data-toggle="tab">
                           Model Test
                        </a>
                      </li>

                      <li role="presentation" >
                        <a href="#nav" aria-controls="nav" role="tab" data-toggle="tab">
                            General
                        </a>
                      </li>

                      
                     
                  </ul><!-- nav -->
            
            <!-- Tab panes -->
                  <div class="tab-content">
                      
                      <div role="tabpanel" class="tab-pane fade in active" id="nav2">
                        <h4></h4>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                              
                              <ul class="sidebar-nav">
                                  <li>
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#contry" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-cog fa-fw fa-lg"></i> Country Module
                                      </a>
                                      <ul id="contry" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/country/index']); ?>">Country List</a></li>
                                          <li><a href="<?= Url::toRoute(['/country/create']); ?>">Create Country</a></li>
                                      </ul>
                                  </li>

                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#category" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-certificate fa-fw fa-lg"></i> Category Module
                                      </a>
                                      <ul id="category" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/category/index']); ?>">Category List</a></li>
                                          <li><a href="<?= Url::toRoute(['/category/create']); ?>">Create Category</a></li>
                                      </ul>
                                  </li>

                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#subject" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-book fa-fw fa-lg"></i> Subject Module
                                      </a>
                                      <ul id="subject" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/subject/index']); ?>">Subject List</a></li>
                                          <li><a href="<?= Url::toRoute(['/subject/create']); ?>">Create Subject</a></li>
                                      </ul>
                                  </li>

                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#chapter" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-book fa-fw fa-lg"></i> Chapter Module
                                      </a>
                                      <ul id="chapter" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/chapter/index']); ?>">Chapter List</a></li>
                                          <li><a href="<?= Url::toRoute(['/chapter/create']); ?>">Create Chapter</a></li>
                                      </ul> 
                                  </li>

                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#question" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-question fa-fw fa-lg"></i> Question Module
                                      </a>
                                      <ul id="question" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/question/index']); ?>">Question List</a></li>
                                          <li><a href="<?= Url::toRoute(['/question/create']); ?>">Create Question</a></li>
                                          <li><a href="<?= Url::toRoute(['/questioncopy/index']); ?>">Copy Question</a></li>
                                      </ul> 
                                  </li>


                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#questionset" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-question fa-fw fa-lg"></i> Question Set Module
                                      </a>
                                      <ul id="questionset" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/questionset/index']); ?>">Question Set List</a></li>
                                          <li><a href="<?= Url::toRoute(['/questionset/create']); ?>">Create Question Set</a></li>                                    
                                          <li><a href="<?= Url::toRoute(['/questionset/assign_questionset']); ?>">Assign Question Set</a></li>
                                          <li><a href="<?= Url::toRoute(['/customquestionset/index']); ?>">Custom Question Set List</a></li>
                                          <li><a href="<?= Url::toRoute(['/customquestionset/create']); ?>">Create Custom Question Set</a></li>
                                      </ul> 
                                  </li>

                                  <li>                                    
                                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#report_section" aria-expanded="true" aria-controls="collapseOne">
                                          <i class="fa fa-square-o fa-fw fa-lg"></i> Report
                                      </a>
                                      <ul id="report_section" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                          <li><a href="<?= Url::toRoute(['/user/question_list_by_user']); ?>">Question list by user</a></li>
                                      </ul> 
                                  </li>

                              </ul>
                             
                                
                           
                        </div>


                      </div>


                      <div role="tabpanel" class="tab-pane fade in " id="nav">
                        <h4></h4>
                        <nav class="main-nav">
                            <ul id="sidebar-nav" class="sidebar-nav">
                              <li class="<?php echo (Yii::$app->controller->id=='site')?'active':''; ?>">
                                  <a href="<?= Url::toRoute(['/site/index']); ?>">
                                    <i class="fa fa-tachometer fa-fw fa-lg"></i> Dashboard 
                                  </a>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='page')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-leanpub fa-fw fa-lg"></i> Page Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/page/list']); ?>">Page List</a></li>
                                    <li><a href="<?= Url::toRoute(['/page/create']); ?>">Create Page</a></li>
                                    <li><a href="<?= Url::toRoute(['/page/archive_list']); ?>">Archived Pages</a></li>
                                  </ul>
                              </li>
                              
                              <li class="<?php echo (Yii::$app->controller->id=='user' || Yii::$app->controller->id=='rbac')?'active':''; ?>">
                                  <a href="#">
                                    <i class="fa fa-user-plus fa-fw fa-lg"></i> User Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/user/index']); ?>">User List</a></li>
                                    <li><a href="<?= Url::toRoute(['/user/create']); ?>">Create User</a></li>                          
                                    <li><a href="<?= Url::toRoute(['/user/unapproved']); ?>">Unapproved User</a></li>   
                                    <li><a href="<?= Url::toRoute(['/user/question_list_by_user']); ?>">Question list by user</a></li>
                                    <li><a href="<?= Url::toRoute(['/rbac/route']); ?>">Manage Route Access</a></li>
                                    <li><a href="<?= Url::toRoute(['/rbac/role']); ?>">Manage User Role</a></li>
                                    <li><a href="<?= Url::toRoute(['/rbac/assignment']); ?>">Manage User Assignment</a></li>
                                  </ul>
                              </li>     

                              <li class="<?php echo (Yii::$app->controller->id=='notificationlist')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-question fa-fw fa-lg"></i> Notification list Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/notificationlist/index']); ?>">Notification List</a></li>
                                    <li><a href="<?= Url::toRoute(['/notificationlist/create']); ?>">Create Notification</a></li>                                    
                                  </ul>
                              </li>

                              <li class="<?php echo (Yii::$app->controller->id=='package')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-cube fa-fw fa-lg"></i> Package Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/package/index']); ?>">Package List</a></li>
                                    <li><a href="<?= Url::toRoute(['/package/create']); ?>">Create Package</a></li>                                    
                                  </ul>
                              </li>

                              <li class="<?php echo (Yii::$app->controller->id=='pointtable')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-arrows-v fa-fw fa-lg"></i> Point Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/pointtable/index']); ?>">Point List</a></li>
                                    <li><a href="<?= Url::toRoute(['/pointtable/create']); ?>">Add New </a></li>                                    
                                  </ul>
                              </li>

                              <li class="<?php echo (Yii::$app->controller->id=='adposition')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-buysellads fa-fw fa-lg"></i> Ad Management Module
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/adposition/index']); ?>">Lists of all ad position</a></li>
                                    <li><a href="<?= Url::toRoute(['/adposition/create']); ?>">Add New ad position </a></li>                                    
                                  </ul>
                              </li>

                              <li class="<?php echo (Yii::$app->controller->id=='blog')?'active':''; ?>" >
                                  <a href="#">
                                    <i class="fa fa-flag fa-fw fa-lg"></i> Blog
                                  </a>
                                  <ul>
                                    <li><a href="<?= Url::toRoute(['/blog/index']); ?>">Lists of all blog</a></li>
                                    <li><a href="<?= Url::toRoute(['/blog/create']); ?>">Add New blog </a></li>                                    
                                  </ul>
                              </li>

                              
                              
                            </ul><!-- sidebar-nav -->
                        </nav>
                    
                    
                      </div><!-- tab-pane -->
                       
                      
                  </div><!-- tab-content -->
              </div><!-- tabpanel -->
              
          </div><!-- sidebar-content -->
        </div><!-- scrollpane -->
    </div><!-- sidebar-container -->
    
  </aside><!-- sidebar -->
      
      
  <!-- MAIN -->
      <div class="main">
      <!-- CONTENT -->
    <div id="content">
        <div class="page-title">
          <h1><?= Html::encode($this->title) ?></h1>
          <?= Breadcrumbs::widget([
              'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
        </div>
        <div class="container-fluid">

            <?= $content ?>

        </div><!-- container-fluid -->
        
    </div><!-- content -->
      <!-- CONTENT -->
    
      <!-- FOOTER -->
    <footer id="footer" role="contentinfo">
        <?= Yii::$app->params['copyright_text']; ?>
    </footer>
      <!-- FOOTER -->
      </div><!-- main -->
  <!-- /MAIN  -->
  </div><!-- wrapper -->
  
 

    <?php $this->endBody() ?>
    </body>



<!-- Mirrored from cazylabs.com/themes-demo/quarca/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 02 Apr 2015 20:06:23 GMT -->
</html>
<?php

        $this->registerJs("
                        
        $( '#top_search' ).submit(function( event ) {
            var form = $(this);
            if(form.find('.search_term').val()=='') {
              $('.search_term').focus();
                    return false;
            }
            
            $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    beforeSend : function( request ){
                      $('#myModal_search .modal-body').html('');
                      $('#myModal_search .modal-body').addClass('loader');
                      $('#myModal_search').modal('show');
                    },
                    success: function(data) {
                      dt = jQuery.parseJSON(data);

                      $('#myModal_search .modal-body').removeClass('loader');
                      $('#myModal_search .modal-body').html(dt.view);
                        
                    }
            });
            event.preventDefault();
        });

        ", yii\web\View::POS_READY, 'search_all');

    ?>
<?php $this->endPage() ?>

  
<div class="modal fade" id="loader_modal"  tabindex="-1" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">

              <div class="cssload-loader">
                  <div class="cssload-inner cssload-one"></div>
                  <div class="cssload-inner cssload-two"></div>
                  <div class="cssload-inner cssload-three"></div>
              </div>

        </div>

      </div>
    </div>
  </div>
  
  <!-- Init -->
  

<!-- Modal -->
    <div class="modal full fade" id="myModal_search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Search Results</h4>
          </div>
          <div class="modal-body">
                    
          </div>
          
        </div>
      </div>
    </div>

<script type="text/javascript">

    $(document).delegate('.full-box-modal', 'click', function() { 

        if($(this).hasClass('open')){
            $(document).fullScreen(false);

            $(this).removeClass('open');

            $(this).parents('.modal-dialog').css('position','unset');
            $(this).parents('.modal-dialog').css('width','900px');
            $(this).parents('.modal-dialog').css('height','auto');
            $(this).parents('.modal-dialog').css('margin','30px auto');
            $(this).parents('.modal-body').css('max-height', '550px');
            $(this).parents('.modal-content').css('height', 'auto');
        }else{
            $(document).fullScreen(true);

          $(this).addClass('open')

          $(this).parents('.modal-dialog').css('position','fixed');
          $(this).parents('.modal-dialog').css('width','100%');
          $(this).parents('.modal-dialog').css('height',$(document).height()+'px');
          $(this).parents('.modal-dialog').css('margin','0px auto');
          $(this).parents('.modal-body').css('max-height',$(document).height()+'px');
          $(this).parents('.modal-content').css('height',$(document).height()+'px');
        }
        
    });
    
</script>