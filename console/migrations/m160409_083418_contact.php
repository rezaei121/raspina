<?php

use yii\db\Schema;
use yii\db\Migration;

class m160409_083418_contact extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(75)->notNull(),
            'email' => $this->string(255)->notNull(),
            'site' => $this->string(2000),
            'message' => $this->text()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0),
            'create_time' => $this->integer(11)->notNull(),
            'ip' => $this->string(20),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contact}}');
    }

}
