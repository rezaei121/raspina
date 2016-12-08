<?php

use yii\db\Schema;
use yii\db\Migration;

class m160409_083040_newsletter extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%newsletter}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull()->unique()
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%newsletter}}');
    }
}
