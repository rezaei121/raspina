<?php

use yii\db\Schema;
use yii\db\Migration;

class m160409_082357_link extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'url' => $this->string(255)->notNull()
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%link}}');
    }
}
