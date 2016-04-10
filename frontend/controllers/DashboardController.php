<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

use frontend\models\User;
use frontend\models\Userexamrel;
use frontend\models\AssignExam;
use frontend\models\Page;
use frontend\models\PurchasedPackage;

/**
 * Site controller
 */

 class DashboardController extends Controller{

 	public function beforeAction($action){
        
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['frontend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['frontend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function() {
                                return isset(\Yii::$app->user->identity);                    
                                },
                    ],
                ],
            ],
            
        ];
    }


    public function actionIndex(){

		$user_data = User::find()->where(['id' => Yii::$app->user->identity->id ])->one();
		
        $total_exam_attended = Userexamrel::find()
            ->where(['user_id' => $user_data->id])
            ->andWhere(['!=','question_set_id','0'])
            ->count();
            

        $exam_data = Userexamrel::find()
            ->where(['user_id'=> $user_data->id])
            ->andWhere(['!=','question_set_id','0'])
            ->one();
        if(empty($exam_data)){
            $question_list = '';
            //throw new NotFoundHttpException('The requested page does not exist.');
        }else{
            $question_list = \yii\helpers\Json::decode($exam_data->exam_questions);
        }

        $get_activity_log_r = Userexamrel::find()->select('DATE(created_at) as created_at')
                                                ->where(['user_id'=>Yii::$app->user->identity->id])
                                                ->distinct()
                                                ->orderBy('id desc')
                                                ->asArray()
                                                ->all();
        $get_activity_log_r = ArrayHelper::getColumn($get_activity_log_r, 'created_at');

        $query = Userexamrel::find()->where(['user_id'=> $user_data->id])
                                    ->andWhere(['DATE(created_at)' => $get_activity_log_r])
                                    ->orderBy('id desc');
        $countQuery = clone $query;
        $exam_rows = new Pagination(['totalCount' => $countQuery->count()]);
        $exam_rows->pageSize = 20;
        $exams = $query->offset($exam_rows->offset)
            ->limit(10)
            ->all();

        $my_assing_exam_list = AssignExam::find()
                            ->where(['assign_to' => $user_data->id])
                            ->andWhere(['status' => 0])
                            ->orderBy('time desc')
                            ->all();

        $page_slug = 'instruction';
        $get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

        $current_date = Date('Y-m-d');
                                        
        $command = Yii::$app->db->createCommand("SELECT sum(points) FROM purchased_package where expired_date >= $current_date && user_id = $user_data->id ");
        $sum_of_points = $command->queryScalar();

        $command_max_date = Yii::$app->db->createCommand("SELECT max(expired_date) FROM purchased_package where expired_date >= $current_date && user_id = $user_data->id ");
        $generate_expired_date = $command_max_date->queryScalar();


        $packages_info = PurchasedPackage::find()->where(['user_id'=>Yii::$app->user->identity->id])
                                                ->andWhere(['!=','points','0'])
                                                ->orderBy('expired_date asc')
                                                ->all();

		return $this->render('index',[
				'user_data' => $user_data,
                'total_exam_attended' => $total_exam_attended,
                'question_list' => $question_list,
                'get_activity_log_r' => $get_activity_log_r,
                'exams' => $exams,
                'exam_rows' => $exam_rows,
                'my_assing_exam_list' => $my_assing_exam_list,
                'get_page_data' => $get_page_data,
                'sum_of_points' => $sum_of_points,
                'generate_expired_date' => $generate_expired_date,
                'packages_info' => $packages_info
			]);

    }
 }