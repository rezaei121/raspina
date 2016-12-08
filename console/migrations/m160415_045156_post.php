<?php

use yii\db\Schema;
use yii\db\Migration;

class m160415_045156_post extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'short_text' => $this->text()->notNull(),
            'more_text' => $this->text(),
            'tags' => $this->text(),
            'keywords' => $this->text(),
            'meta_description' => $this->string(255),
            'status' => $this->integer(1)->defaultValue(1),
            'create_time' => $this->integer(10)->notNull(),
            'update_time' => $this->integer(10),
            'author_id' => $this->integer(11)->notNull(),
            'pin_post' => $this->integer(1)->defaultValue(0),
            'comment_active' => $this->integer(1)->defaultValue(1),
            'view' => $this->integer(11)->defaultValue(0),
            'send_newsletter' => $this->integer(1)->defaultValue(0),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%post}}');
    }
}
