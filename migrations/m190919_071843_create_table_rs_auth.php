<?php

use yii\db\Migration;

class m190919_071843_create_table_rs_auth extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->bigInteger()->unsigned()->notNull(),
            'created_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%auth_item}}', [
            'name' => $this->string()->notNull()->append('PRIMARY KEY'),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string()->notNull(),
            'child' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string()->notNull()->append('PRIMARY KEY'),
            'data' => $this->binary(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addPrimaryKey('PRIMARYKEY', '{{%auth_assignment}}', ['item_name', 'user_id']);
        $this->createIndex('user_id', '{{%auth_assignment}}', 'user_id');
        $this->addForeignKey('rs_auth_assignment_ibfk_1', '{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('rs_auth_assignment_ibfk_2', '{{%auth_assignment}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->createIndex('rule_name', '{{%auth_item}}', 'rule_name');
        $this->createIndex('idx-auth_item-type', '{{%auth_item}}', 'type');
        $this->addForeignKey('rs_auth_item_ibfk_1', '{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'SET NULL', 'CASCADE');

        $this->addPrimaryKey('PRIMARYKEY', '{{%auth_item_child}}', ['parent', 'child']);
        $this->createIndex('child', '{{%auth_item_child}}', 'child');
        $this->addForeignKey('rs_auth_item_child_ibfk_1', '{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');
        $this->addForeignKey('rs_auth_item_child_ibfk_2', '{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE');

        $this->batchInsert('{{%auth_rule}}', ['name', 'data'], [
            ['AuthorRule', 'O:36:"dashboard\components\rbac\AuthorRule":3:{s:4:"name";s:10:"AuthorRule";s:9:"createdAt";i:1501851319;s:9:"updatedAt";i:1501851319;}']
        ]);

        $this->batchInsert('{{%auth_item}}', ['name', 'type', 'rule_name'], [
            ['admin','1',null],
            ['approveComment','2',null],
            ['approveOwnComment','2',null],
            ['author','1',null],
            ['category','2',null],
            ['comment','2',null],
            ['contact','2',null],
            ['deleteCategory','2',null],
            ['deleteComment','2',null],
            ['deleteContact','2',null],
            ['deleteFile','2',null],
            ['deleteLink','2',null],
            ['deleteNewsletter','2',null],
            ['deleteOwnCategory','2',null],
            ['deleteOwnComment','2',null],
            ['deleteOwnFile','2',null],
            ['deleteOwnPost','2',null],
            ['deletePost','2',null],
            ['deleteUser','2',null],
            ['file','2',null],
            ['link','2',null],
            ['moderator','1',null],
            ['newsletter','2',null],
            ['post','2',null],
            ['replyComment','2',null],
            ['replyOwnComment','2',null],
            ['settings','2',null],
            ['statistics','2',null],
            ['template','2',null],
            ['updateCategory','2',null],
            ['updateLink','2',null],
            ['updateOwnCategory','2',null],
            ['updateOwnPost','2',null],
            ['updatePost','2',null],
            ['updateUser','2',null],
            ['user','2',null]
        ]);

        $this->batchInsert('{{%auth_item_child}}', ['parent', 'child'], [
            ['admin','approveComment'],
            ['moderator','approveComment'],
            ['author','approveOwnComment'],
            ['admin','category'],
            ['author','category'],
            ['moderator','category'],
            ['admin','comment'],
            ['author','comment'],
            ['moderator','comment'],
            ['admin','contact'],
            ['moderator','contact'],
            ['admin','deleteCategory'],
            ['moderator','deleteCategory'],
            ['admin','deleteComment'],
            ['moderator','deleteComment'],
            ['admin','deleteContact'],
            ['moderator','deleteContact'],
            ['admin','deleteFile'],
            ['moderator','deleteFile'],
            ['admin','deleteLink'],
            ['moderator','deleteLink'],
            ['admin','deleteNewsletter'],
            ['moderator','deleteNewsletter'],
            ['author','deleteOwnCategory'],
            ['author','deleteOwnComment'],
            ['author','deleteOwnFile'],
            ['author','deleteOwnPost'],
            ['admin','deletePost'],
            ['moderator','deletePost'],
            ['admin','deleteUser'],
            ['admin','file'],
            ['author','file'],
            ['moderator','file'],
            ['admin','link'],
            ['moderator','link'],
            ['admin','newsletter'],
            ['moderator','newsletter'],
            ['admin','post'],
            ['author','post'],
            ['moderator','post'],
            ['admin','replyComment'],
            ['moderator','replyComment'],
            ['author','replyOwnComment'],
            ['admin','settings'],
            ['moderator','settings'],
            ['admin','statistics'],
            ['author','statistics'],
            ['moderator','statistics'],
            ['admin','template'],
            ['moderator','template'],
            ['admin','updateCategory'],
            ['moderator','updateCategory'],
            ['admin','updateLink'],
            ['moderator','updateLink'],
            ['author','updateOwnCategory'],
            ['author','updateOwnPost'],
            ['admin','updatePost'],
            ['moderator','updatePost'],
            ['admin','updateUser'],
            ['admin','user']
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_assignment}}');
    }
}
