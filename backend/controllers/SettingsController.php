<?php

namespace backend\controllers;

use Yii;
use backend\models\Settings;
use backend\models\SettingsSearch;
use backend\models\ProductCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/**
 * SettingsController implements the CRUD actions for Settings model.
 */
class SettingsController extends Controller
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

    /**
     * Lists all Settings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $themes_array = array();
       // echo dirname(__FILE__).'/../web/themes';
        

        $dir = dirname(__FILE__).'/../web/themes';
        
        $directories = array_slice(scandir($dir), 2);
        foreach ($directories as $key => $value) {

            if (is_dir($dir.'/'.$value)) {
                $filename = '';
                $files = '';
                $images = '';


                $dh  = opendir($dir.'/'.$value);

                while (false !== ($filename = readdir($dh))) {
                    $files[] = $filename;
                }
                $images=preg_grep ('/\.jpg$/i', $files);

                
                if(empty($images)){
                    $img = Url::to('@web/image/default.jpg', true);
                }else{
                    $img = Url::to('@web/themes/'.$value.'/'.reset($images), true);
                }

                array_push($themes_array, array('name'=>$value, 
                                                'image'=>$img,
                                                ));
            }
        }



        $editor_array = array();
        $dir_editor = dirname(__FILE__).'/../web/ckeditor/config';
        
        $filename = '';
        $configs = '';

        $dh  = opendir($dir_editor);

        while (false !== ($filename = readdir($dh))) {
            $configs[] = $filename;
        }
        
        

        $id =1;
        return $this->render('index', [
                'themes_array'=>$themes_array,
                'configs'=>array_slice($configs,2)
            ]);
    }

    public function actionActivate_theme(){
        if( Yii::$app->request->isAjax ){
            $name = $_POST['name'];
            $type = $_POST['type'];

            if(!empty($name)){ 

                    $file = dirname(__FILE__).'/../../common/config/params.json';
                    $string = file_get_contents($file);
                    $json_a = json_decode($string, true);

                    if($type=='back'){
                        $json_a['backend.theme'] = $name;
                    }else{
                        $json_a['frontend.theme'] = $name;
                    }
                    

                    $new_string = "<?php return [\n";
                    $i=0;
                    foreach ($json_a as $key => $value) {
                        if($i==0){
                            $new_string .= "'".$key."' => '".$value."'";
                        }else{
                            $new_string .= ",\n'".$key."' => '".$value."'";
                        }
                        $i++;
                    }
                    $new_string .= "\n];";

                    $file_php = dirname(__FILE__).'/../../common/config/params.php';
                    $fd_php=fopen($file_php,"w");
                    fwrite($fd_php, $new_string);
                    fclose($fd_php);


                    $json_a_new = json_encode($json_a, true);
                    $fd_json=fopen($file,"w");
                    fwrite($fd_json, $json_a_new);
                    fclose($fd_json);

                    $response['result'] = 'success';
                    $response['msg'] = 'Theme Activated.';
            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error Activating theme.';
            }

            return json_encode($response);
        }
    }

    public function actionSave_settings(){
        if( Yii::$app->request->isAjax ){
            $admin_email = $_POST['admin_email'];
            $contact_email = $_POST['contact_email'];
            $copyright_text = $_POST['copyright_text'];
            $site_title = $_POST['site_title'];
            $facebook = $_POST['facebook'];
            $twitter = $_POST['twitter'];
            $linkedin = $_POST['linkedin'];
            $editor = $_POST['editor'];
            $Class_VIII_XII_Practice = $_POST['Class_VIII_XII_Practice'];
            $others_Practice = $_POST['others_Practice'];
            $Class_VIII_XII_ModelTest = $_POST['Class_VIII_XII_ModelTest'];
            $others_ModelTest = $_POST['others_ModelTest'];
            $vat = $_POST['vat'];

            $model_test_plus_points=$_POST['model_test_plus_points'];
            $model_test_minus_points=$_POST['model_test_minus_points'];
            $practice_exam_plus_points = $_POST['practice_exam_plus_points'];
            $practice_exam_minus_points = $_POST['practice_exam_minus_points'];
            $previous_exam_class_xi_xii_plus_points = $_POST['previous_exam_class_xi_xii_plus_points'];
            $previous_exam_class_xi_xii_minus_points = $_POST['previous_exam_class_xi_xii_minus_points'];
            $previous_exam_admission_plus_points = $_POST['previous_exam_admission_plus_points'];
            $previous_exam_admission_minus_points = $_POST['previous_exam_admission_minus_points'];
            $previous_exam_job_plus_points = $_POST['previous_exam_job_plus_points'];
            $previous_exam_job_minus_points = $_POST['previous_exam_job_minus_points'];

            if(!empty($admin_email)){ 

                $file = dirname(__FILE__).'/../../common/config/params.json';
                $string = file_get_contents($file);
                $json_a = json_decode($string, true);
                
                $json_a['admin_email'] = $admin_email;
                $json_a['contact_email'] = $contact_email;
                $json_a['copyright_text'] = $copyright_text;
                $json_a['site_title'] = $site_title;
                $json_a['facebook'] = $facebook;
                $json_a['twitter'] = $twitter;
                $json_a['linkedin'] = $linkedin;
                $json_a['editor'] = $editor;
                $json_a['Class_VIII_XII_Practice'] = $Class_VIII_XII_Practice;
                $json_a['others_Practice'] = $others_Practice;
                $json_a['Class_VIII_XII_ModelTest'] = $Class_VIII_XII_ModelTest;
                $json_a['others_ModelTest'] = $others_ModelTest;
                $json_a['vat'] = $vat;

                $json_a['model_test_plus_points'] =$model_test_plus_points;
                $json_a['model_test_minus_points'] =$model_test_minus_points;
                $json_a['practice_exam_plus_points'] =$practice_exam_plus_points;
                $json_a['practice_exam_minus_points'] =$practice_exam_minus_points;
                $json_a['previous_exam_class_xi_xii_plus_points'] =$previous_exam_class_xi_xii_plus_points;
                $json_a['previous_exam_class_xi_xii_minus_points'] =$previous_exam_class_xi_xii_minus_points;
                $json_a['previous_exam_admission_plus_points'] = $previous_exam_admission_plus_points;
                $json_a['previous_exam_admission_minus_points'] = $previous_exam_admission_minus_points;
                $json_a['previous_exam_job_plus_points'] = $previous_exam_job_plus_points;
                $json_a['previous_exam_job_minus_points'] = $previous_exam_job_minus_points;

                $new_string = "<?php return [\n";
                $i=0;
                foreach ($json_a as $key => $value) {
                    if($i==0){
                        $new_string .= "'".$key."' => '".$value."'";
                    }else{
                        $new_string .= ",\n'".$key."' => '".$value."'";
                    }
                    $i++;
                }
                $new_string .= "\n];";

                $file_php = dirname(__FILE__).'/../../common/config/params.php';
                $fd_php=fopen($file_php,"w");
                fwrite($fd_php, $new_string);
                fclose($fd_php);


                $json_a_new = json_encode($json_a, true);
                $fd_json=fopen($file,"w");
                fwrite($fd_json, $json_a_new);
                fclose($fd_json);

                $response['result'] = 'success';
                $response['msg'] = 'Settings Saved.';

            }
            else{
                $response['result'] = 'error';
                $response['msg'] = 'Error saving settings.';
            }

            return json_encode($response);
        }
    }

    /**
     * Displays a single Settings model.
     * @param integer $id
     * @return mixed
     */
    public function actionTabular_input()
    {
            $model = new ProductCategory();
            $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pagesize' => 5
                ]
            ]);
            $models = $dataProvider->getModels();

        
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['ProductCategory']) && isset($_POST['ProductCategory']['cat_create']) ) {
                $model = new ProductCategory();
                $model->attributes = $_POST['ProductCategory'];
            
                if($model->save()){

                    $response['files'] = ['ok'];
                    $response['result'] = 'success';

                    $model_uu = new ProductCategory();
                    $query = ProductCategory::find()->indexBy('id'); // where `id` is your primary key
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pagesize' => 5
                        ]
                    ]);
                    $models = $dataProvider->getModels();
                    $response['post_list'] = $this->renderAjax('ajax_cont', ['dataProvider'=>$dataProvider,'model'=>$model_uu]);
                    return json_encode($response);
                }else{
                    $response['result'] = 'error';
                    $response['files'] =  Html::errorSummary($model);
                    return json_encode($response);
                }
            }
            else if (ProductCategory::loadMultiple($models, Yii::$app->request->post()) && ProductCategory::validateMultiple($models)) {
                $count = 0;
                foreach ($models as $index => $model) {
                    // populate and save records for each model
                    if ($model->save()) {
                        $count++;
                    }
                }
                Yii::$app->session->setFlash('success', "Processed {$count} records successfully.");
                $response['files'] = "Processed {$count} records successfully.";
                $response['result'] = 'success';

                return json_encode($response);
            } 
        }

        

        return $this->render('tabular_input',['dataProvider'=>$dataProvider,'model'=>$model]);

    }


}
