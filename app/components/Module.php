<?php

namespace app\components;


use Yii;

class Module extends \yii\base\Module
{
    private $_viewPath;
    public $defaultApp = 'frontend';
    public $appName = '';
    public function init()
    {
        $this->appName = \Yii::$app->request->get('app', $this->defaultApp);
        $this->controllerNamespace = 'app\modules\\'.$this->id.'\controllers\\' . \Yii::$app->request->get('app', $this->defaultApp);
        if($this->appName == $this->defaultApp)
        {
            $this->layoutPath = Yii::$app->params['templateLayout'];
            $this->layout = 'main.twig';
        }
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function getViewPath()
    {
        if($this->appName != $this->defaultApp)
        {
            if ($this->_viewPath === null) {
                $this->_viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . \Yii::$app->request->get('app', $this->defaultApp);
            }
        }
        else
        {
            $this->_viewPath = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'themes';
        }
        return $this->_viewPath;
    }
}
