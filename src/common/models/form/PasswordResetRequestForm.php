<?php

namespace common\models\form;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    private $_timeout;

    private $_user = false;

    /**
     * PasswordResetRequestForm constructor.
     * @param array $timeout
     * @param array $config
     */
    public function __construct($timeout, $config = [])
    {
        if (empty($timeout)) {
            throw new InvalidParamException('Timeout cannot be blank.');
        }
        $this->_timeout = $timeout;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required', 'message' => Yii::t('app', 'Это поле обязательное')],
            ['email', 'email', 'message' => Yii::t('app', 'Не венрный адрес электронной почты')],
            ['email', 'exist',
                'targetClass' => User::className(),
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Yii::t('app', 'Пользователь с таким e-mail не найден')
            ],
            ['email', 'validateIsSent'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-mail'),
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function validateIsSent($attribute, $params)
    {
        if (!$this->hasErrors() && $user = $this->getUser()) {
            if ($user->isPasswordResetTokenValid($this->_timeout)) {
                $this->addError($attribute, Yii::t('app', 'Токен уже отправлен.'));
            }
        }
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        if ($user = $this->getUser()) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                $mailer = Yii::$app->mailer;
                $mailer->htmlLayout = '@common/mail/layouts/html';
                return $mailer->compose('@common/mail/passwordReset', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . Yii::$app->name)
                    ->send();
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne([
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE,
            ]);
        }

        return $this->_user;
    }
}