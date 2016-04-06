<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use common\models\query\UserQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use common\helpers\UserHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $username
 * @property string $auth_key
 * @property string $email_confirm_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $role
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;

    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;

    const PASSWORD_RESET_TOKEN_EXPIRE = 3600;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'Этот имя пользовате уже занято')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email', 'message' => Yii::t('app', 'Не вернный адрес электронной почты')],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'Этот e-mail уже занят')],
            ['email', 'string', 'max' => 255],

            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],
            ['role', 'safe'],

            [['status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('app', 'Создан'),
            'updated_at' => Yii::t('app', 'Обновлён'),
            'username' => Yii::t('app', 'Имя пользователя'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Роль'),
            'status' => Yii::t('app', 'Статус'),
            'auth_key' => Yii::t('app', 'Ключ авторизации'),
            'email_confirm_token' => Yii::t('app', 'Токен подтверждения E-mail'),
            'password_hash' => Yii::t('app', 'Хэш пароля'),
            'password_reset_token' => Yii::t('app', 'Токен сброса пароля'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @param $username
     * @return bool
     */
    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN]))
        {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function loginAdmin()
    {
        if ($this->validate() && User::isUserAdmin($this->username)) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
        ];
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return ArrayHelper::getValue(self::getRoleArray(), $this->role);
    }

    /**
     * @return array
     */
    public static function getRoleArray()
    {
        return [
            self::ROLE_USER => 'Клиент',
            self::ROLE_ADMIN => 'Администратор',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }


    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_WAIT]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @param integer $timeout
     * @return static|null
     */
    public static function findByPasswordResetToken($token, $timeout)
    {
        if (!UserHelper::isPasswordResetTokenValid($token, $timeout)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param integer $timeout
     * @return bool
     */
    public function isPasswordResetTokenValid($timeout)
    {
        return UserHelper::isPasswordResetTokenValid($this->password_reset_token, $timeout);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = UserHelper::generatePasswordResetToken();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }
}