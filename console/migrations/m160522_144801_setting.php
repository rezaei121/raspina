<?php

use yii\db\Migration;

class m160522_144801_setting extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%setting}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(2000)->notNull(),
            'template' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255),
            'keyword' => $this->text(),
            'page_size' => $this->integer(3)->notNull()->defaultValue(0),
            'date_format' => $this->string(255),
            'sult' => $this->string(17),
            'activation_newsletter' => $this->integer(1)->defaultValue(1)
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
