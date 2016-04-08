<?php

use yii\db\Migration;
use common\models\User;

class m160408_174338_fill_user_and_bill_admin extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
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

        $this->insert('{{%bills}}', [
                'user_id' => 1,
                'balance' => 0,
                'created_at' => time(),
                'updated_at' => time(),
            ]
        );
    }

    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
        $this->delete('{{%bills}}', ['user_id' => 1]);
    }
}
