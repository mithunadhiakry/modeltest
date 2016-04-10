<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

use frontend\models\Country;
use frontend\models\Tempquestionlist;
use frontend\models\Rest;
use frontend\models\Userexamrel;
use frontend\models\Page;
use frontend\models\AssignExam;
use kartik\mpdf\Pdf;
use yii\imagine\Image;
use frontend\models\User;
use frontend\models\AdManagement;

/**
 * Exam controller
 */

class ExamController extends Controller{


	public function actionExamcenter(){

		$get_all_country = Country::find()->where(['status' => '1'])->all();
		
		$page_slug = 'instruction';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

        $examcenter_slug = 'exam-center';
        $get_examcenter_data = Page::find()->where(['page_slug'=>$examcenter_slug])->one();

        $get_institution_list_r = User::find()
        						->where(['user_type' => 'institution'])
        						->andWhere(['status' => 1])
        						->all();

        $advertisement_top_right_r = AdManagement::find()
                            ->where(['ad_identifier' => '3'])
                            ->all();

        $advertisement_bottom_right_r = AdManagement::find()
                            ->where(['ad_identifier' => '4'])
                            ->all();

        $advertisement_bottom_left_r = AdManagement::find()
                            ->where(['ad_identifier' => '5'])
                            ->all();

		return $this->render('examcenter',[
				'get_all_country_r' => $get_all_country,
				'get_page_data' => $get_page_data,
				'get_examcenter_data' => $get_examcenter_data,
				'get_institution_list_r' => $get_institution_list_r,
				'advertisement_top_right_r' => $advertisement_top_right_r,
				'advertisement_bottom_right_r' => $advertisement_bottom_right_r,
				'advertisement_bottom_left_r' => $advertisement_bottom_left_r
			]);
	}

	public function actionReport($exam_id){
		$session = Yii::$app->session;

		$user_id = \Yii::$app->user->identity->id;

        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id,'user_id'=>$user_id])->one();
        if(empty($exam_data)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if($session->has('current_exam_id')){
	        $question_list_array = [];
	        $question_list = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'user_id'=>$user_id])->all();

	        foreach ($question_list as $key) {
	        	$question_list_array[$key->serial] = $key;
	        }
	        $exam_data->exam_questions = \yii\helpers\Json::encode($question_list_array);
	        $exam_data->save();

	        foreach ($question_list as $key) {
	        	$key->delete();
	        }

	        $assined_exam_data = AssignExam::find()->where(['exam_id_of_attend' => $session->get('current_exam_id')])->one();
	        if(!empty($assined_exam_data)){
	        	$assined_exam_data->status = 1;
	        	$assined_exam_data->save();
	        }

	        $session->remove('current_exam_id');
	        $session->remove('current_exam_time.hours');
	        $session->remove('current_exam_time.mins');
	        $session->remove('current_exam_time.secs');
	        $session->remove('total_time_timestamp');
	        $session->remove('current_exam_start_time');
	        $session->remove('current_question_id');
	    }
	    else{
	    	$question_list = \yii\helpers\Json::decode($exam_data->exam_questions);
	    }
	    

	    $assign_exam_list_r = AssignExam::find()
	    						->where(['assign_by' => $user_id])
	    						->andWhere(['exam_id' => $exam_id])
	    						->all();

	    $page_slug = 'instruction';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

        $advertisement_r = AdManagement::find()
                            ->where(['ad_identifier' => '6'])
                            ->all();

        $advertisement_print_r = AdManagement::find()
                            ->where(['ad_identifier' => '7'])
                            ->all();

        return $this->render('report',[
        			'question_list' => $question_list,
        			'exam_data' => $exam_data,
        			'assign_exam_list_r' => $assign_exam_list_r,
        			'get_page_data' => $get_page_data,
        			'advertisement_r' => $advertisement_r,
        			'advertisement_print_r' => $advertisement_print_r
        	]);
	}


	public function actionView($exam_id){
		$session = Yii::$app->session;
		if(!$session->has('current_exam_id')){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

       	
        $exam_id = $session->get('current_exam_id');

		$questions = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'user_id'=>\Yii::$app->user->identity->id])->all();
		if(empty($questions)){
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$chapters = Tempquestionlist::find()->select('chapter_id')
						->where(['exam_id'=>$exam_id,
								'user_id'=>\Yii::$app->user->identity->id])
						->orderBy('serial asc')
						->groupBy('chapter_id')
						->all();
		
	
		Rest::updateSession();
		if($session->has('current_question_id')){
			$current_question_id = $session->get('current_question_id');
			$new_question = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'question_id'=>$current_question_id])->one();

	    }else{
	    	$new_question = $questions[0];
	    	$session->set('current_question_id',$questions[0]->question_id);
	    }

	    $page_slug = 'instruction';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

		return $this->render('view',[
						'exam_id' => $exam_id,
						'chapters' => $chapters,
						'question' => $new_question,
						'question_list' => $questions,
						'exam_time_hours' => $session->get('current_exam_time.hours'),
						'exam_time_mins' => $session->get('current_exam_time.mins'),
						'exam_time_secs' => $session->get('current_exam_time.secs'),
						'get_page_data' => $get_page_data
					]);
	}


	public function actionSummarize_report($exam_id){
		$session = Yii::$app->session;

		$user_id = \Yii::$app->user->identity->id;

        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id,'user_id'=> $user_id ])->one();
        if(empty($exam_data)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);

        $assign_exam_list_r = AssignExam::find()
	    						->where(['assign_by' => $user_id])
	    						->andWhere(['exam_id' => $exam_id])
	    						->all();

	    $page_slug = 'instruction';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

        $advertisement_r = AdManagement::find()
                            ->where(['ad_identifier' => '9'])
                            ->all();

        $advertisement_print_r = AdManagement::find()
                            ->where(['ad_identifier' => '7'])
                            ->all();

		return $this->render('summarize_report',[
        			'question_list' => $question_list,
        			'exam_data' => $exam_data,
        			'exam_id' => $exam_id,
        			'assign_exam_list_r' => $assign_exam_list_r,
        			'get_page_data' => $get_page_data,
        			'advertisement_r' => $advertisement_r,
        			'advertisement_print_r' => $advertisement_print_r
        	]);
	}

	public function actionPrint($exam_id){
		
		$content = $this->renderPartial('_reportView');

            $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8, 
                // A4 paper format
                'format' => Pdf::FORMAT_A4, 
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                'filename' => time().'report.pdf',
                // stream to browser inline
                'destination' => Pdf::DEST_BROWSER, 
                // your html content input
                'content' => $content,  
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting 
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                // any css to be embedded if required
                'cssInline' => '.kv-heading-1{font-size:18px}', 
                 // set mPDF properties on the fly
                'options' => ['title' => 'Model Test.'],
                 // call mPDF methods on the fly
                'methods' => [ 
                    'SetHeader'=>[
                            '<div class="invoice_footer">
                                <div class="footer_left" style="float:left;width:20%;">
                                    <p style="font-size:11px; text-align:left;">Model Test.</p>
                                </div>
                                <div class="footer_right" style="float:right;width:20%;">
                                    <p style="font-size:11px;">'.date("Y-m-d H:i:s").'</p>
                                </div>
                                        </div>'], 
                    'SetFooter' =>  [
                                        '<div class="invoice_footer">
                                            <div class="footer_left">
                                                <p style="font-size:11px; text-align:left;">Customer Signature</p>
                                            </div>
                                            <div class="footer_right">
                                                <p style="font-size:11px;">Authorised Sinature</p>
                                            </div>
                                        </div>'
                                    ],
                ]
            ]);

        return $pdf->render();
	}






	public function actionEnd_exam(){
		$session = Yii::$app->session;
		if($session->has('current_exam_id')){
			$exam_id = $session->get('current_exam_id');
			$user_id = Yii::$app->user->identity->id;

	        $question_list_array = [];
	        $exam_data = Userexamrel::find()->where(['exam_id'=>$exam_id,'user_id'=>$user_id])->one();
	        $question_list = Tempquestionlist::find()->where(['exam_id'=>$exam_id,'user_id'=>$user_id])->all();

	        foreach ($question_list as $key) {
	        	$question_list_array[$key->serial] = $key;
	        }
	        $exam_data->exam_questions = \yii\helpers\Json::encode($question_list_array);
	        $exam_data->save();

	        foreach ($question_list as $key) {
	        	$key->delete();
	        }

	        $assined_exam_data = AssignExam::find()->where(['exam_id_of_attend' => $session->get('current_exam_id')])->one();
	        if(!empty($assined_exam_data)){
	        	$assined_exam_data->status = 1;
	        	$assined_exam_data->save();
	        }


	        $session->remove('current_exam_id');
	        $session->remove('current_exam_time.hours');
	        $session->remove('current_exam_time.mins');
	        $session->remove('current_exam_time.secs');
	        $session->remove('total_time_timestamp');
	        $session->remove('current_exam_start_time');
	        $session->remove('current_question_id');
	    }
	}


}