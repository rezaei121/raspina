<?php
namespace app\components\bootstrap;

use app\models\Modules;
use Yii;
use yii\base\BootstrapInterface;

class ModuleLoader implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $modules = Modules::findAll(['status' => Modules::ACTIVE]);
        $config = [];
        foreach ((array)$modules as $m)
        {
            $config[$m->name] = $m->path;
        }
        Yii::$app->modules = $config;
    }
}
