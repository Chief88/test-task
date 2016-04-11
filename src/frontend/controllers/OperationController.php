<?php

namespace frontend\controllers;

use Yii;
use common\models\Operation;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\form\TransferForm;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * OperationController implements the CRUD actions for Operation model.
 */
class OperationController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'transfer' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all Operation models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$operations = Operation::find()
			->andWhere('recipient_id = :recipientId', [
				':recipientId' => Yii::$app->user->id,
			])
			->orderBy('id DESC')->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $operations,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Lists all Operation models.
	 * @return mixed
	 */
	public function actionFundsSent()
	{
		$operations = Operation::find()
			->andWhere('sender_id = :senderId', [
				':senderId' => Yii::$app->user->id,
			])
			->orderBy('id DESC')->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $operations,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('fundsSent', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Operation model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionTransfer()
	{
		$model = new TransferForm();

		if (Yii::$app->request->isAjax) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			if ($model->load(Yii::$app->request->post()) && $model->validate()) {
				return true;
			}
			return ActiveForm::validate($model);
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->transfer();
			$this->redirect(Url::previous());
		}
	}

	/**
	 * Finds the Operation model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Operation the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Operation::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
