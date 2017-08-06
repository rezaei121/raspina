<?php
namespace dashboard\components\rbac;

use dashboard\modules\post\models\Post;
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'AuthorRule';

    public function execute($user, $item, $params)
    {
        $methodName = $item->name;
        return $this->{$methodName}($user, $item, $params);
    }

    public function updatePost($user, $item, $params)
    {
        if(isset($params['model']) && !$params['model'] instanceof Post)
        {
            return true;
        }

        if(isset($params['model']) && $params['model'] instanceof Post)
        {
            if($params['model']->created_by == $user)
            {
                return true;
            }
        }

        return false;
    }

    public function deletePost($user, $item, $params)
    {
        if(isset($params['model']) && !$params['model'] instanceof Post)
        {
            return true;
        }

        if(isset($params['model']) && $params['model'] instanceof Post)
        {
            if($params['model']->created_by == $user)
            {
                return true;
            }
        }

        return false;
    }
}