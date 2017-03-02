<?php

use yii\db\Schema;
use yii\db\Migration;

class m160415_054931_comment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'post_id' => $this->integer(11)->notNull()->unsigned(),
            'name' => $this->string(60)->notNull(),
            'email' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(0)->unsigned(),
            'reply_text' => $this->text(),
            'create_time' => $this->integer(11)->notNull()->unsigned(),
            'ip' => $this->string(20),
        ],$tableOptions);

        $this->addForeignKey('fk_post_comment','{{%comment}}','post_id','{{%post}}','id','CASCADE');
        $this->createIndex('index_post_id','{{%comment}}','post_id');
    }

    public function down()
    {
        $this->dropTable('{{%comment}}');
    }
}
