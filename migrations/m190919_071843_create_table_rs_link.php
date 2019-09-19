<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_link extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%link}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%link}}');
    }
}
