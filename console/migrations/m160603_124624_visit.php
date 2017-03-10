<?php

use yii\db\Migration;

class m160603_124624_visit extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%visitors}}', [
            'id' => $this->primaryKey()->unsigned(),
            'ip' => $this->string(20),
            'visit_date' => $this->integer(11)->unsigned(),
            'group_date' => $this->integer(11)->unsigned(),
            'location' => $this->string(2000),
            'browser' => $this->string(60),
            'os' => $this->string(30),
            'referer' => $this->string(2000),
            'user_agent' => $this->string(2000)
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%visitors}}');
    }
}
