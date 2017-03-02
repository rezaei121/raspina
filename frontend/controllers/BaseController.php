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
        return Yii::getAlias('@frontend/views/template/') . $this->setting['template'] . '/';
    }

    private function _setOptions()
    {
        #set date format
        if(!defined('DATE_FROMAT'))
        {
            define('DATE_FROMAT',$this->setting['date_format']);
        }
        # description
        if(isset($this->view->params['description']) && !empty($this->view->params['description']))
        {
            Yii::$app->view->params['description'] = $this->setting['description'] . ' - ' . Yii::$app->view->params['description'];
        }
        else
        {
            if(isset($this->setting['description']) && !empty($this->setting['description']))
            {
                Yii::$app->view->params['description'] = $this->setting['description'];
            }
            else
            {
                Yii::$app->view->params['description'] = '';
            }
        }
        # keywords
        if(isset($this->view->params['keywords']) && !empty($this->view->params['keywords']))
        {
            Yii::$app->view->params['keywords'] = $this->setting['keyword'] . ',' . Yii::$app->view->params['keywords'];
        }
        else
        {
            if(isset($this->setting['keyword']) && !empty($this->setting['keyword']))
            {
                Yii::$app->view->params['keywords'] = $this->setting['keyword'];
            }
            else
            {
                Yii::$app->view->params['keywords'] = '';
            }
        }
        # templateUrl
        Yii::$app->view->params['templateUrl'] = $this->setting['templateUrl'];
        # templateDir
        Yii::$app->view->params['templateDir'] = $this->setting['templateDir'];
        # title
        Yii::$app->view->title = $this->setting['title'];

        Yii::$app->view->params['subject'] = $this->setting['title'];
        Yii::$app->view->params['siteDescription'] = $this->setting['description'];
        # lang
        Yii::$app->view->params['lang'] = Yii::$app->language;
        # charset
        Yii::$app->view->params['charset'] = Yii::$app->charset;
        # csrfMetaTags
        Yii::$app->view->params['csrfMetaTags'] = Html::csrfMetaTags();
        # url
        Yii::$app->view->params['url'] = $this->setting['url'];
        # categories
        Yii::$app->view->params['categories'] = \frontend\models\Category::getAll();
        # links
        Yii::$app->view->params['links'] = \frontend\models\Link::getAll();
        # about
        $about = new \yii\db\Query();
        Yii::$app->view->params['about'] = $about->select('avatar,name,short_text,facebook,twitter,googleplus,instagram,linkedin')->from(\frontend\models\About::tableName())->one();
        # model
        Yii::$app->view->params['newsletter'] = new \frontend\models\Newsletter;
        # site
        Yii::$app->view->params['index'] = new \frontend\models\Site;
    }

    public function render($view, $params = [])
    {
        $this->_setOptions();

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
