<?php
namespace app\components\rbac;

use app\modules\file\models\File;
use app\modules\post\models\Category;
use app\modules\post\models\Comment;
use app\modules\post\models\Post;
use Yii;
use yii\rbac\Rule;
use yii\web\NotFoundHttpException;

class AuthorRule extends Rule
{
    public $name = 'AuthorRule';
    private $_model;
    private $_user;

    public function execute($user, $item, $params)
    {
        $methodName = $item->name;
        $this->_user = $user;

        if(!isset(Yii::$app->authManager->getRolesByUser($user)['author']))
        {
            return false;
        }

        return $this->{$methodName}($params);
    }

    public function updateOwnPost($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Post)
        {
            return true;
        }

        return $this->_checkOwnerEntity();
    }

    public function deleteOwnPost($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Post)
        {
            return true;
        }

        return $this->_checkOwnerEntity();
    }

    public function updateOwnCategory($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Category)
        {
            return true;
        }

        return $this->_checkOwnerEntity();
    }

    public function deleteOwnCategory($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Category)
        {
            return true;
        }

        return $this->_checkOwnerEntity();
    }

    public function deleteOwnComment($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Comment)
        {
            return true;
        }

        return $params['model']->post->created_by == $this->_user;
    }

    public function deleteOwnfile($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof File)
        {
            return true;
        }

        return $params['model']->uploaded_by == $this->_user;
    }

    public function approveOwnComment($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Comment)
        {
            return true;
        }

        return $params['model']->post->created_by == $this->_user;
    }

    public function replyOwnComment($params)
    {
        $this->_findModel($params);
        if(!$params['model'] instanceof Comment)
        {
            return true;
        }

        return $params['model']->post->created_by == $this->_user;
    }

    private function _checkOwnerEntity()
    {
        return $this->_model->created_by == $this->_user;
    }

    private function _findModel($params)
    {
        if(isset($params['model']))
        {
            $this->_model = $params['model'];
        }
        else
        {
            throw new NotFoundHttpException('The model does not exist.');
        }
    }
}
