<?php

use yii\db\Migration;
use common\models\User;

class m160406_143953_add_admin_user extends Migration
{
	public function safeUp()
	{
		$this->insert('{{%user}}', [
				'username' => 'admin',
				'role' => User::ROLE_ADMIN,
				'auth_key' => '100500',
				'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('123456'),
				'email' => 'serg.latyshkov@gmail.com',
				'status' => User::STATUS_ACTIVE,
				'created_at' => time(),
				'updated_at' => time(),
			]
		);
	}

	public function safeDown()
	{
		$this->delete('{{%user}}', ['username' => 'admin']);
	}
}
