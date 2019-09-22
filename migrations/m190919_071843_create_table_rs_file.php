<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_file extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
            'size' => $this->bigInteger()->unsigned()->notNull(),
            'extension' => $this->string()->notNull(),
            'content_type' => $this->string()->notNull(),
            'uploaded_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'uploaded_by' => $this->bigInteger()->unsigned()->notNull(),
            'real_name' => $this->string()->notNull(),
            'download_count' => $this->bigInteger()->unsigned()->notNull()->defaultValue('0'),
        ], $tableOptions);

        $this->createIndex('uploaded_by', '{{%file}}', 'uploaded_by');
        $this->addForeignKey('rs_file_ibfk_1', '{{%file}}', 'uploaded_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%file}}');
    }
}
