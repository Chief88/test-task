<?php

use yii\db\Migration;

class m160405_073047_user_base extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'role' => $this->integer()->notNull()->defaultValue(10),
            'auth_key' => $this->string(32),
            'email_confirm_token' => $this->string(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_status', '{{%user}}', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
