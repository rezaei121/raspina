<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_post extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'short_text' => $this->text()->notNull(),
            'more_text' => $this->text(),
            'keywords' => $this->text(),
            'meta_description' => $this->string(),
            'status' => $this->integer()->unsigned()->defaultValue('1'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->bigInteger()->unsigned(),
            'updated_by' => $this->bigInteger()->unsigned(),
            'pin_post' => $this->integer()->unsigned()->defaultValue('0'),
            'enable_comments' => $this->integer()->unsigned()->defaultValue('1'),
            'view' => $this->bigInteger()->unsigned()->defaultValue('0'),
        ], $tableOptions);

        $this->createTable('{{%category}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->string(128)->notNull(),
            'slug' => $this->string()->notNull(),
            'created_by' => $this->bigInteger()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%tag}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->string(128)->notNull(),
            'slug' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%comment}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'post_id' => $this->bigInteger()->unsigned()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->integer()->unsigned()->notNull()->defaultValue('0'),
            'reply_text' => $this->text(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->bigInteger()->unsigned(),
            'updated_by' => $this->bigInteger()->unsigned(),
            'ip' => $this->string(),
        ], $tableOptions);

        $this->createTable('{{%post_category}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'post_id' => $this->bigInteger()->unsigned()->notNull(),
            'category_id' => $this->bigInteger()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%post_tag}}', [
            'id' => $this->bigPrimaryKey(),
            'post_id' => $this->bigInteger()->unsigned()->notNull(),
            'tag_id' => $this->bigInteger()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('author_id', '{{%post}}', 'created_by');
        $this->addForeignKey('rs_post_ibfk_1', '{{%post}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('rs_post_ibfk_2', '{{%post}}', 'updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('fk_post_category', '{{%post_category}}', 'category_id');
        $this->createIndex('index_post_category', '{{%post_category}}', ['post_id', 'category_id']);
        $this->addForeignKey('rs_post_category_ibfk_1', '{{%post_category}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('rs_post_category_ibfk_2', '{{%post_category}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('post_id', '{{%post_tag}}', ['post_id', 'tag_id'], true);
        $this->addForeignKey('rs_post_tag_ibfk_1', '{{%post_tag}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('rs_post_tag_ibfk_2', '{{%post_tag}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('name', '{{%tag}}', 'title', true);

        $this->createIndex('title', '{{%category}}', 'title', true);
        $this->createIndex('user_id', '{{%category}}', 'created_by');
        $this->addForeignKey('rs_category_ibfk_1', '{{%category}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('index_post_id', '{{%comment}}', 'post_id');
        $this->createIndex('updated_by', '{{%comment}}', 'updated_by');
        $this->createIndex('created_by', '{{%comment}}', 'created_by');
        $this->addForeignKey('rs_comment_ibfk_2', '{{%comment}}', 'updated_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('rs_comment_ibfk_3', '{{%comment}}', 'post_id', '{{%post}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('rs_comment_ibfk_1', '{{%comment}}', 'created_by', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%post_tag}}');
        $this->dropTable('{{%post_category}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%post}}');
    }
}
