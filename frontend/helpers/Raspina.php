<?php
namespace frontend\helpers;
use Yii;
class Raspina
{
    public static function title($title = null)
    {
        if($title !== null)
        {
            Yii::$app->view->title .= ' - ' . $title;
        }
        return Yii::$app->view->title;
    }

    public static function description()
    {
        return Yii::$app->view->params['description'];
    }

    public static function keywords()
    {
        return Yii::$app->view->params['keywords'];
    }

    public static function csrfMetaTags()
    {
        return Yii::$app->view->params['csrfMetaTags'];
    }

    public static function charset()
    {
        return Yii::$app->view->params['charset'];
    }

    public static function templateUrl()
    {
        return Yii::$app->view->params['templateUrl'];
    }

    public static function siteDescription()
    {
        return Yii::$app->view->params['siteDescription'];
    }

    public static function subject()
    {
        return Yii::$app->view->params['subject'];
    }

    public static function url()
    {
        return Yii::$app->view->params['url'];
    }

    public static function isAvatar()
    {
        if(Yii::$app->view->params['about']['avatar'])
        {
            return true;
        }
        return false;
    }

    public static function avatarImage()
    {
        return Yii::$app->view->params['url'] . 'common/files/avatar/' . Yii::$app->view->params['about']['avatar'];
    }

    public static function authorName()
    {
        return Yii::$app->view->params['about']['name'];
    }

    public static function aboutText()
    {
        return Yii::$app->view->params['about']['short_text'];
    }

    public static function facebook()
    {
        return Yii::$app->view->params['about']['facebook'];
    }

    public static function twitter()
    {
        return Yii::$app->view->params['about']['twitter'];
    }

    public static function googleplus()
    {
        return Yii::$app->view->params['about']['googleplus'];
    }

    public static function instagram()
    {
        return Yii::$app->view->params['about']['instagram'];
    }

    public static function linkedin()
    {
        return Yii::$app->view->params['about']['linkedin'];
    }
    
    public static function siteModel()
    {
        return Yii::$app->view->params['index'];
    }

    public static function newsletterModel()
    {
        return Yii::$app->view->params['newsletter'];
    }

    public static function categories()
    {
        return Yii::$app->view->params['categories'];
    }

    public static function links()
    {
        return Yii::$app->view->params['links'];
    }

    public static function lang()
    {
        return Yii::$app->view->params['lang'];
    }
}
