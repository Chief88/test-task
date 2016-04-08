<?php

use yii\db\Migration;

class m160406_164505_operations_base extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%operations}}', [
            'id' => $this->primaryKey(),
            'sender_bill_id' => $this->integer()->notNull(),
            'recipient_bill_id' => $this->integer()->notNull(),
            'amount' => $this->float()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_ad' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%operations}}');
    }
}
