<?php

namespace backend\controllers;

use Yii;
use  yii\web\Session;

use backend\models\Question;
use backend\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use backend\models\Model;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Html;

use backend\models\Copyqueston;
use backend\models\AnswerList;



class QuestioncopyController extends Controller
{
    public function beforeAction($action){
        $this->getView()->theme = Yii::createObject([
            'class' => '\yii\base\Theme',
            'pathMap' => ['@app/views' => '@app/web/themes/'.Yii::$app->params['backend.theme']],
            'baseUrl' => '@web/themes/'.Yii::$app->params['backend.theme'],
        ]);

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    public function actionIndex(){
        $model = new Copyqueston();
        $from_data = array();
        $to_data = array();

        if ($model->load(Yii::$app->request->post())) {


            $to_data = Question::find()->where(['country_id'=>$model->to_country])
                                         ->andWhere(['category_id'=>$model->to_category])
                                         ->andWhere(['sub_category_id'=>$model->to_subcategory])
                                         ->andWhere(['subject_id'=>$model->to_subject])
                                         ->andWhere(['chapter_id'=>$model->to_chapter])
                                         ->andWhere(['!=','copied_from',''])
                                         ->all();

            $to_ids_q = Question::find()->select('parent_question')
                                        ->where(['country_id'=>$model->to_country])
                                         ->andWhere(['category_id'=>$model->to_category])
                                         ->andWhere(['sub_category_id'=>$model->to_subcategory])
                                         ->andWhere(['subject_id'=>$model->to_subject])
                                         ->andWhere(['chapter_id'=>$model->to_chapter])
                                         ->andWhere(['!=','copied_from',''])
                                         ->asArray()
                                         ->all();

            $to_ids = ArrayHelper::getColumn($to_ids_q, 'parent_question');

            $from_data = Question::find()->where(['country_id'=>$model->from_country])
                                         ->andWhere(['category_id'=>$model->from_category])
                                         ->andWhere(['sub_category_id'=>$model->from_subcategory])
                                         ->andWhere(['subject_id'=>$model->from_subject])
                                         ->andWhere(['chapter_id'=>$model->from_chapter])
                                         ->andWhere(['not in','id',$to_ids])
                                         ->all();
            
        }

        return $this->render('index',['model'=>$model,'from_data'=>$from_data,'to_data'=>$to_data]);
    }

    public function actionCopy_questions(){
        if( Yii::$app->request->isAjax ){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $ids = $_POST['ids'];
            $from = $_POST['from'];
            $to = $_POST['to'];

            $to_array = explode('-', $to);
            $to_country = $to_array[0];
            $to_category = $to_array[1];
            $to_subcategory = $to_array[2];
            $to_subject = $to_array[3];
            $to_chapter = $to_array[4];


            if(!empty($ids)){
                foreach ($ids as $key => $value) {
                    $q = Question::find()->where(['id'=>$value])
                                         ->one();
                    

                    $new = new Question();
                    $new->country_id = $to_country;
                    $new->category_id = $to_category;
                    $new->sub_category_id = $to_subcategory;
                    $new->subject_id = $to_subject;
                    $new->chapter_id = $to_chapter;
                    $new->status = 1;
                    $new->details = $q->details;
                    $new->copied_to = $to;
                    $new->copied_from = $from;
                    $new->parent_question = $q->id;

                    if($new->save()){
                        if(!empty($q->answers)){
                            foreach ($q->answers as $ans) {
                                $n_ans = new AnswerList();
                                $n_ans->question_id = $new->id;
                                $n_ans->answer = $ans->answer;
                                $n_ans->is_correct = $ans->is_correct;
                                $n_ans->sort_order = $ans->sort_order;
                                $n_ans->question_id = $new->id;
                                $n_ans->save();
                            }
                        }
                    }
                }
            }

            $response['result'] = 'success';
            $response['msg'] = $ids;
            $response['from'] = $from;
            $response['to'] = $to;
            return $response;

        }
    }

    public function actionRemove_questions(){
        if( Yii::$app->request->isAjax ){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $response = [];

            $ids = $_POST['ids'];

            if(!empty($ids)){
                foreach ($ids as $key => $value) {
                    $q = Question::find()->where(['id'=>$value])
                                         ->one();
                    
                    $answers = $q->answers;
                    if($q->delete()){
                        if(!empty($answers)){
                            foreach ($answers as $ans) {
                                $ans->delete();
                            }
                        }
                    }
                }
            }

            $response['result'] = 'success';
            $response['msg'] = $ids;
            return $response;

        }
    }


}
