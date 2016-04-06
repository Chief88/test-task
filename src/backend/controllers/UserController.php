<?php
namespace backend\controllers;

use common\models\form\LoginForm;
use common\models\User;
use backend\components\BackendController as Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\web\Response;
use yii\data\ArrayDataProvider;

class UserController extends Controller
{
	/**
	 * @return array
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
							return User::isUserAdmin(Yii::$app->user->identity->username);
						}
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @return array
	 */
	public function actions()
	{
		return [
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * @return string|Response
	 */
	public function actionLogin()
	{
		$model = new LoginForm();
		$post = Yii::$app->request->post();

		if ($model->load($post) && $model->login()) {
			return $this->goHome();
		}

		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * @return string|Response
	 */
	public function actionIndex()
	{
		$models = User::find()
			->andWhere('status = :status', [
				':status' => User::STATUS_ACTIVE,
			])
			->orderBy('id DESC')->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $models,
			'pagination' => [
				'pageSize' => 5,
			],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}
}