<?php

namespace common\models\form;

use common\models\Bills;
use common\models\User;
use common\models\Operation;
use yii\base\Model;
use Yii;

/**
 * Class TransferForm
 * @package backend\models\form
 */
class TransferForm extends Model
{
	public $sender_id;
	public $email;
	public $amount;

	public function rules()
	{
		return [
			[['sender_id', 'amount', 'email'], 'required'],
			['sender_id', 'integer'],

			[['amount'], 'number', 'min' => 0.01],
			[['amount'], 'validateMaxAmount'],

			['email', 'filter', 'filter' => 'trim'],
			['email', 'email'],
			['email', 'validateNotYourEmail'],
			['email', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'email', 'message' => Yii::t('app', 'Пользователь с таким e-mail не найден')],
		];
	}

	public function validateMaxAmount($attribute,$params)
	{
		$balance = Bills::findOne(['user_id' => $this->sender_id])->balance;
		if ($this->amount > $balance){
			$this->addError($attribute, Yii::t('app', 'Не достатосно средств, максимум {max}', ['max' => $balance]));
		}
	}

	public function validateNotYourEmail($attribute,$params)
	{
		if ($this->email == Yii::$app->user->identity->email){
			$this->addError($attribute, Yii::t('app', 'Нельзя перевести самому себе'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'sender_id' => Yii::t('app', 'Отправитель'),
			'email' => Yii::t('app', 'E-mail полуателя'),
			'amount' => Yii::t('app', 'Сумма'),
		];
	}

	/**
	 * @return Operation|null
	 */
	public function transfer()
	{
		if ($this->validate()) {
			$operation = new Operation();
			$operation->sender_id = $this->sender_id;
			$operation->recipient_id = User::findByEmail($this->email)->id;
			$operation->amount = $this->amount;
			$operation->type = Operation::TYPE_TRANSFER;

			if ($operation->save()) {
				Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Средства успешно переведены.'));
			}

			return $operation;
		}

		return null;
	}
}