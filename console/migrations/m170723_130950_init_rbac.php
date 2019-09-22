<?php

use yii\db\Migration;

class m170723_130950_init_rbac extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // permissions
        $post = $auth->createPermission('post');
        $auth->add($post);

        $category = $auth->createPermission('category');
        $auth->add($category);

        $file = $auth->createPermission('file');
        $auth->add($file);

        $statistics = $auth->createPermission('statistics');
        $auth->add($statistics);

        $administrator = $auth->createPermission('management');
        $auth->add($administrator);

//        // Roles
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $post);
        $auth->addChild($author, $category);
        $auth->addChild($author, $file);
        $auth->addChild($author, $statistics);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $administrator);

    }

    public function safeDown()
    {
        return false;
    }
}
