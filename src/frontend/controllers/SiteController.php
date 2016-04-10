<?php
namespace frontend\controllers;

use Yii;
use frontend\models\form\SignupForm;
use frontend\components\FrontController as Controller;
use yii\filters\VerbFilter;
use common\models\User;
use yii\data\ArrayDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * @return string
	 */
	public function actionIndex()
	{
		$model = new SignupForm();
		$model->setScenario('user');
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Подтвердите ваш e-mail адрес.'));
				return $this->goHome();
			}
		}

		$models = User::find()
			->andWhere('status = :status', [
				':status' => User::STATUS_ACTIVE,
			])
			->orderBy('id DESC')->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $models,
			'pagination' => [
				'pageSize' => 8,
			],
		]);

		return $this->render('index', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}
}