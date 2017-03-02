<?php

use yii\db\Schema;
use yii\db\Migration;

class m160409_081901_file extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'size' => $this->integer()->notNull()->unsigned(),
            'extension' => $this->string(4)->notNull(),
            'content_type' => $this->string(55)->notNull(),
            'upload_date' => $this->integer()->notNull()->unsigned(),
            'user_id' => $this->integer(11)->notNull()->unsigned(),
            'real_name' =>  $this->string()->notNull(),
            'download_count' => $this->integer(11)->notNull()->defaultValue(0)->unsigned(),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%file}}');
    }
}
