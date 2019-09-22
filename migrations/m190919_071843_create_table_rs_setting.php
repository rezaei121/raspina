<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'url' => $this->string()->notNull(),
            'template' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'keyword' => $this->text(),
            'page_size' => $this->integer()->unsigned()->notNull()->defaultValue('0'),
            'language' => $this->string(),
            'direction' => $this->string(),
            'time_zone' => $this->string(),
            'date_format' => $this->string(),
            'sult' => $this->string(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
