<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

use frontend\models\BlogComments;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles | Model Test';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="inner_container">
            
            <div class="inner_common_page margin-top-30">
                <h3>Articles</h3>
                <div class="blog-body margin-top-20">
                    
                    <?php
                        foreach($blogs_data as $blogs){
                    ?>

                            <div class="blog_container">
                        
                                <div class="blog-blogTitle">
                                    <a href="<?= Url::toRoute(['blog/view?id='.$blogs->id]); ?>"><?= $blogs->name; ?></a>
                                </div>
                                <div class="blog-author">
                                    <a href="#">
                                        <span class="blog-authorName">
                                            <?php
                                                    echo $blogs->author_name->name;
                                            ?>
                                        </span>
                                    </a>
                                    <span class="blog-postingDate">
                                        <?= date_format(date_create($blogs->created_at), 'jS F\, Y h:i A'); ?>                                        
                                    </span>

                                    <span class="blog-postingDate">
                                      Views ( <?= $blogs->count;?> )
                                        
                                    </span>

                                    <span class="blog-postingDate">
                                        Comment (
                                          <?php

                                            $blog_comments_data = BlogComments::find()
                                              ->where(['blog_id' => $blogs->id])
                                               ->count(); 
                                            echo $blog_comments_data;
                                          ?>
                                        )                                                                              
                                    </span>
                                </div>
                                <div class="blog-comment">
                                    <?= $blogs->short_description; ?>
                                </div>

                                <a href="<?= Url::toRoute(['article/view/'.$blogs->id]); ?>" class="view_my_profile">Read Article</a>


                            </div>

                    <?php
                        }

                    ?>
                    

                    <div class="pagination_container">
                        
                        <?php
                             LinkPager::widget(['pagination' => $blog_rows,
                                                 'lastPageLabel'=>false,
                                                 'firstPageLabel'=>false,
                                                 'prevPageLabel' => 'Prev',
                                                 'nextPageLabel' => 'Next',
                                                 'maxButtonCount' =>1
                             ]) 
                        ?>

                    </div>
                    
                </div>
            </div>
    
            
            

        </div>
    </div>
</div>
<?php

$this->registerJs("
        // window.fbAsyncInit = function() {
        //       FB.init({
        //         appId      : '709957295722222',
        //         cookie     : true,  // enable cookies to allow the server to access 
        //                             // the session
        //         xfbml      : true,  // parse social plugins on this page
        //         version    : 'v2.2' // use version 2.2
        //       });

        //         if (typeof facebookInit == 'function') {
        //             checkLoginState();
        //         }

        //   };

        //   // Load the SDK asynchronously
        //   (function(d, s, id) {
        //     var js, fjs = d.getElementsByTagName(s)[0];
        //     if (d.getElementById(id)) return;
        //     js = d.createElement(s); js.id = id;
        //     js.src = '//connect.facebook.net/en_US/sdk.js';
        //     fjs.parentNode.insertBefore(js, fjs);
        //   }(document, 'script', 'facebook-jssdk'));


        // // This is called with the results from from FB.getLoginStatus().
        //   function statusChangeCallback(response) {
        //     console.log('statusChangeCallback');
        //     console.log(response);

        //     if (response.status === 'connected') {
        //       // Logged into your app and Facebook.
        //       testAPI();
        //     } else if (response.status === 'not_authorized') {
        //       // The person is logged into Facebook, but not your app.
        //       document.getElementById('status').innerHTML = 'Please log ' +
        //         'into this app.';
        //     } else {
        //       // The person is not logged into Facebook, so we're not sure if
        //       // they are logged into this app or not.
        //       document.getElementById('status').innerHTML = 'Please log ' +
        //         'into Facebook.';
        //     }
        //   }

        //   var fb_share = '1';
        //   if(fb_share == '1'){
        //     setTimeout(function(){
        //         checkLoginState();
        //       },5000);
        //   }
          
          

        //   function checkLoginState() {
            
        //     FB.login(function(response) {
        //        if (response.authResponse) {
        //          statusChangeCallback(response);
        //        } else {
        //          console.log('User cancelled login or did not fully authorize.');
        //        }
        //      });

        //   }

         
        //   function testAPI() {
        //     FB.ui({
        //       method: 'share',
        //       href: 'http://dcastalia.com/projects/web/model_test',
        //     }, function(response){
        //         var exam_id = '14_njsdn121';
        //         if(response.post_id){
        //             $.ajax({
        //                 type : 'POST',
        //                 dataType : 'json',
        //                 url : '".Url::toRoute('rest/save_fb_share_point')."',
        //                 data: {exam_id:exam_id},
        //                 beforeSend : function( request ){
        //                     $('.css_loader_container_wrap').fadeIn();
        //                 },
        //                 success : function( data )
        //                     {   
        //                         $('.css_loader_container_wrap').fadeOut();
        //                         if(data.result == 'success'){
        //                             alert(data.msg);
        //                         }
        //                         else if(data.result == 'error'){
        //                             alert(data.msg);
        //                         }
        //                     }
        //             });
        //         }

        //     });
            
        //   }       
    ", yii\web\View::POS_READY, 'fb_login');
?>