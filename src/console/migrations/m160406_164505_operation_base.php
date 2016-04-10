<?php

use yii\db\Migration;

class m160406_164505_operation_base extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%operation}}', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer(),
            'recipient_id' => $this->integer()->notNull(),
            'owner_id' => $this->integer()->notNull(),
            'amount' => 'NUMERIC(10,2) NOT NULL',
            'balance_sender' => 'NUMERIC(10,2)',
            'balance_recipient' => 'NUMERIC(10,2) NOT NULL',
            'type' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%operation}}');
    }
}
