<?php
namespace backend\controllers;

use common\models\form\LoginForm;
use frontend\models\form\SignupForm;
use common\models\form\EmailConfirmForm;
use common\models\form\PasswordResetRequestForm;
use common\models\form\PasswordResetForm;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\components\BackendController as Controller;
use Yii;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

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
	 * @return string|Response
	 */
	public function actionPasswordResetRequest()
	{
		$model = new PasswordResetRequestForm(User::PASSWORD_RESET_TOKEN_EXPIRE);
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'На почту отправлено соощение с сменой пароля!'));

				return $this->goHome();
			} else {
				Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Не удалось отправить сообщение на указанный email!'));
			}
		}

		return $this->render('passwordResetRequest', [
			'model' => $model,
		]);
	}

	/**
	 * @param $token
	 * @return string|Response
	 * @throws BadRequestHttpException
	 */
	public function actionPasswordReset($token)
	{
		try {
			$model = new PasswordResetForm($token, User::PASSWORD_RESET_TOKEN_EXPIRE);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Спасибо! Пароль успешно изменён.'));

			return $this->goHome();
		}

		return $this->render('passwordReset', [
			'model' => $model,
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