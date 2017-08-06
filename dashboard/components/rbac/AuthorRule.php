<?php
namespace dashboard\components\rbac;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'AuthorRule';

    public function execute($user, $item, $params)
    {
        return $params['post']->author_id == $user;
        $methodName = $item->name;
        $this->{$methodName}($user, $item, $params);
    }

    public function updatePost($user, $item, $params)
    {
        var_dump($params); exit();
    }
}