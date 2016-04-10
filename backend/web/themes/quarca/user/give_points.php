<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use app\models\User;
use backend\models\Subject;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

use yii\widgets\Pjax;

use backend\models\Country;
use backend\models\Category;
use backend\models\Chapter;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Give Points';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="question-index pane" style="float:left;width:100%;">

        <a style="margin-bottom:20px;" class="discounts_height" href="<?= Url::toRoute(['discounts/index']);?>">Discounts</a>
        <a style="background:#16a085;margin-bottom:20px;" class="discounts_height" href="<?= Url::toROute(['user/give_points']);?>">User Free Points</a>

        <?php $form = ActiveForm::begin([
            'id' => 'user-form',
            'method'=>'POST'
        ]); ?>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="userfront-country">Student Email</label>
                        
                            <?php
                                echo $form->field($model, 'id')->widget(Select2::classname(), [
                                    'data' => User::get_all_studentuser_list(),
                                    'options' => ['placeholder' => 'Select a student ...','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'pluginEvents' =>[
                                        "change" => "function() { 
                                            $('#user-form').submit();
                                         }",
                                    ]
                                ])->label(false);    
                            ?>
                        
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    <div class="col-md-12 css_loader_wrap" style="position:relative;min-height:100px;">
        <div class="css_loader_container_wrap22" style="position:absolute;width:100%;height:100%;background:rgba(0,0,0,0.1);z-index:10; display:none">
            <div class="css_loader_container">
                <div class="cssload-loader"></div>
            </div>
        </div>

        <div class="points_table_holder">
            
        </div>
        
        
    </div>

    
    

</div>


<?php
    $this->registerJs("

        $(document).ready(
                $(document).delegate('#user-form', 'beforeSubmit', function(event, jqXHR, settings) {
                    
                        var form = $(this);
                        if(form.find('.has-error').length) {
                                return false;
                        }
                        
                        $.ajax({
                                url: form.attr('action'),
                                type: 'post',
                                data: form.serialize(),
                                beforeSend : function( request ){
                                    $('.css_loader_wrap .css_loader_container_wrap22').fadeIn();
                                },
                                success: function(data) {
                                    $('.css_loader_wrap .css_loader_container_wrap22').fadeOut();

                                    dt = jQuery.parseJSON(data);
                                    $('.points_table_holder').html(dt.msg);
                                }
                        });
                        
                        return false;
                })
            );

    ", yii\web\View::POS_END, 'post_submit_update');

    $this->registerJs("

        $(document).delegate('.send_point_btn','click',function(){
            var point = $('#point').val();
            var user_id = $('#user_id').val();
            if(isNaN(point) || point == ''){
                alert('Please enter numeric value.');
                return false;
            }

            $.ajax({
                type : 'POST',
                dataType : 'json',
                url : '".Url::toRoute(['user/give_points_req'])."',
                data: {user_id:user_id,point:point},
                beforeSend : function( request ){
                    $('.css_loader_wrap .css_loader_container_wrap22').fadeIn();
                },
                success : function( data )
                    {   
                        $('.css_loader_wrap .css_loader_container_wrap22').fadeOut();
                        if(data.result == 'success'){
                            $('.points_table_holder').html(data.view);
                            BootstrapDialog.alert({
                                 title: 'SUCCESSFULL',
                                 'message': data.msg
                            });
                        }
                        if(data.result == 'error'){
                            
                            BootstrapDialog.alert({
                                 title: 'WARNING',
                                 'message': data.msg
                            });

                        }
                    }
            });
        });

    ", yii\web\View::POS_END, 'send_point_btn');


?>