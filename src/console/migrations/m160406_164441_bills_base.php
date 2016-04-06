<?php

use yii\db\Migration;

class m160406_164441_bills_base extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%bills}}', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull(),
			'balance' => $this->float()->notNull()->defaultValue(0),
			'created_at' => $this->integer()->notNull(),
			'updated_ad' => $this->integer()->notNull(),
		], $tableOptions);
	}

	public function safeDown()
	{
		$this->dropTable('{{%bills}}');
	}
}
