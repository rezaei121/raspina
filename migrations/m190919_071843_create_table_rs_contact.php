<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contact}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'site' => $this->string(),
            'message' => $this->text()->notNull(),
            'status' => $this->integer()->unsigned()->notNull()->defaultValue('0'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'ip' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }
}
