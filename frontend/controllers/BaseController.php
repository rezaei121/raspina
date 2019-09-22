<?php
namespace frontend\controllers;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;

/**
 * Class BaseController
 * @package frontend\controllers
 */

class BaseController extends Controller
{
    public $setting = '';
    public $descriptuion;

    public function init()
    {
        // filter out garbage requests
        $uri = Yii::$app->request->url;
        if (strpos($uri, 'favicon.ico') || strpos($uri, 'robots') || strpos($uri, 'bootstrap.min.css.map'))
            Yii::$app->end();
        // do the other initialization stuff
        $this->setting = \Yii::$app->setting->get();
        parent::init();
    }

    public function getViewPath()
    {
        return Yii::getAlias('@frontend/views/templates/') . $this->setting['template'] . '/';
    }

    public function render($view, $params = [])
    {
        // visit +
        $exception = Yii::$app->errorHandler->exception;
        if(empty($exception))
        {
            $visitors = new \common\models\Visitors;
            $visitors->add();
        }

        return parent::render($view,$params);
    }
}
