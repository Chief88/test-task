<?php

namespace backend\models\form;

use common\models\Bills;
use common\models\User;
use common\models\Operation;
use yii\base\Model;
use Yii;

/**
 * Class EnrollForm
 * @package backend\models\form
 */
class EnrollForm extends Model
{
	public $recipient_id;
	public $amount;

	public function rules()
	{
		return [
			[['recipient_id', 'amount'], 'required'],
			['recipient_id', 'integer'],

			[['amount'], 'number', 'min' => 0.01],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'recipient_id' => Yii::t('app', 'Получатель'),
			'amount' => Yii::t('app', 'Сумма'),
		];
	}

	/**
	 * @return Operation|null
	 */
	public function enroll()
	{
		if ($this->validate()) {
			$operation = new Operation();
			$operation->recipient_id = $this->recipient_id;
			$operation->amount = $this->amount;
			$operation->type = Operation::TYPE_ENROLL;

			if ($operation->save()) {
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Средства успешно зачислены.'));
			}

			return $operation;
		}

		return null;
	}
}