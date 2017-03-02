<?php

use yii\db\Schema;
use yii\db\Migration;

class m160415_051211_category extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(255)->notNull()->unique()
        ],$tableOptions);

        $this->createTable('{{%post_category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'post_id' => $this->integer(11)->notNull()->unsigned(),
            'category_id' => $this->integer(11)->notNull()->unsigned()
        ],$tableOptions);

        $this->addForeignKey('fk_post_category','{{%post_category}}','category_id','{{%category}}','id','CASCADE');
        $this->addForeignKey('fk_post','{{%post_category}}','post_id','{{%post}}','id','CASCADE');
        $this->createIndex('index_post_category','{{%post_category}}',['post_id','category_id']);
    }

    public function down()
    {
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%post_category}}');
    }
}
