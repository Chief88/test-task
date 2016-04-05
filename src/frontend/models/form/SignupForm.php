<?php

namespace frontend\models\form;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $username;
	public $email;
	public $password;
	public $verifyCode;

	public function rules()
	{
		return [
			['username', 'filter', 'filter' => 'trim'],
			['username', 'required'],
			['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
			['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'Этот имя пользовате уже занято')],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'Этот e-mail уже занят')],

			['password', 'required'],
			['password', 'string', 'min' => 6],

			['verifyCode', 'captcha', 'captchaAction' => '/user/captcha'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'email' => Yii::t('app', 'E-mail'),
			'username' => Yii::t('app', 'Имя пользователя'),
			'password' => Yii::t('app', 'Пароль'),
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if ($this->validate()) {
			$user = new User();
			$user->username = $this->username;
			$user->email = $this->email;
			$user->setPassword($this->password);
			$user->status = User::STATUS_WAIT;
			$user->role = User::ROLE_USER;
			$user->generateAuthKey();
			$user->generateEmailConfirmToken();

			if ($user->save()) {
				$mailer = Yii::$app->mailer;
				$mailer->htmlLayout = '@common/mail/layouts/html';
				$mailer->compose('@common/mail/emailConfirm', ['user' => $user])
					->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
					->setTo($this->email)
					->setSubject('Email confirmation for ' . Yii::$app->name)
					->send();
			}

			return $user;
		}

		return null;
	}
}