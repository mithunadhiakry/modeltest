<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;

use yii\web\Controller;
use yii\web\NotFoundHttpException;


use frontend\models\Page;
use frontend\models\Package;
use frontend\models\PointTable;
use frontend\models\Contactform;
use frontend\models\Discounts;

/**
 * Page controller
 */
class PageController extends Controller{

	public function actionMembership(){


		$package_model = new Package();
		$membership_data_r = Package::find()->all();
		$columns = Package::getTableSchema()->getColumnNames();


		return $this->render('membership',[
					'membership_data_r' => $membership_data_r,
					'columns' => $columns,
					'package_model' => $package_model
			]);


	}


	public function actionPointsRewards(){

		$point_slug = 'points';
		$get_point_data = Page::find()->where(['page_slug'=>$point_slug])->one();

		$rewards_slug = 'rewards';
		$get_rewards_data = Page::find()->where(['page_slug'=>$rewards_slug])->one();

		$all_point_data_r = PointTable::find()->orderBy('sort_order asc')->all();

		return $this->render('points_rewards',[
				'get_point_data' => $get_point_data,
				'all_point_data_r' => $all_point_data_r,
				'get_rewards_data' => $get_rewards_data
			]);


	}

	public function actionDiscounts(){

		$discounts_data = Discounts::find()
							->where(['status' => 1])
							->orderBy('discounts_year desc,discounts_slot asc')
							->groupBy('discounts_slot')
							->limit(5)
							->all();

		$discounts_text = Page::find()->where(['id'=>'44'])->one();


		return $this->render('discounts',[
				'discounts_data' => $discounts_data,
				'discounts_text' => $discounts_text
			]);


	}

	public function actionAboutUs(){

		$page_slug = 'about-us';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionHowToPay(){
		
		$page_slug = 'how-to-pay';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionFaq(){
		$page_slug = 'faq';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionTermsOfUse(){
		$page_slug = 'terms-of-use';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionPrivacyPolicy(){
		
		$page_slug = 'privacy-policy';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionInstruction(){
		$page_slug = 'instruction';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionBatches(){

		$page_slug = 'batches';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionStudents(){

		$page_slug = 'students';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionHowToAssign(){
		
		$page_slug = 'how-to-assign';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionHowToCreateExam(){
		
		$page_slug = 'how-to-create-exam';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);
	}

	public function actionContactUs(){

		$contactus_model = new Contactform();
		$page_slug = 'contact-us';
		$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();
		return $this->render('contactus',[
					'get_page_data' => $get_page_data,
					'contactus_model' => $contactus_model
			]);
	}

	public function actionViewcommonpage($page_slug){

		if($page_slug == 'membership'){
			$package_model = new Package();
			$membership_data_r = Package::find()->all();
			$columns = Package::getTableSchema()->getColumnNames();


			return $this->render('membership',[
						'membership_data_r' => $membership_data_r,
						'columns' => $columns,
						'package_model' => $package_model
				]);

		}else if($page_slug == 'points-rewards'){

			$point_slug = 'points';
			$get_point_data = Page::find()->where(['page_slug'=>$point_slug])->one();

			$rewards_slug = 'rewards';
			$get_rewards_data = Page::find()->where(['page_slug'=>$rewards_slug])->one();

			$all_point_data_r = PointTable::find()->orderBy('sort_order asc')->all();

			return $this->render('points_rewards',[
					'get_point_data' => $get_point_data,
					'all_point_data_r' => $all_point_data_r,
					'get_rewards_data' => $get_rewards_data
				]);

		}else if($page_slug == 'contact-us'){

			$contactus_model = new Contactform();

			$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();
			return $this->render('contactus',[
						'get_page_data' => $get_page_data,
						'contactus_model' => $contactus_model
				]);

		}else if($page_slug == 'discounts'){

			$discounts_data = Discounts::find()
								->where(['status' => 1])
								->orderBy('discounts_year desc,discounts_slot asc')
								->groupBy('discounts_slot')
								->limit(5)
								->all();

			$discounts_text = Page::find()->where(['id'=>'44'])->one();


			return $this->render('discounts',[
					'discounts_data' => $discounts_data,
					'discounts_text' => $discounts_text
				]);

		}else{

			$get_page_data = Page::find()->where(['page_slug'=>$page_slug])->one();

			return $this->render('commonpage',[
					'get_page_data'=>$get_page_data
				]);

		}
		
		
	}
}
?>