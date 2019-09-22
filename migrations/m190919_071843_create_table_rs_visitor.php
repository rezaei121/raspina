<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_visitor extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%visitor}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'ip' => $this->string(),
            'visit_date' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'group_date' => $this->integer()->unsigned(),
            'location' => $this->string(),
            'browser' => $this->string(),
            'browser_version' => $this->string(),
            'os' => $this->string(),
            'os_version' => $this->string(),
            'device' => $this->string(),
            'device_model' => $this->string(),
            'referer' => $this->string(),
        ], $tableOptions);

        $this->createIndex('id', '{{%visitor}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%visitor}}');
    }
}
