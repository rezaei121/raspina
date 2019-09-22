<?php
namespace app\modules\template\models;

use Yii;

class Template extends \app\components\Model
{
    public function getAllTemplates()
    {
        $templates = scandir(\Yii::getAlias('@templatePath'));

        $result = [];
        foreach ((array)$templates as $t)
        {
            if($t == '.' || $t == '..')
            {
                continue;
            }

            $result[$t]['snapshot'] = Yii::$app->params['url'] . 'themes/' . $t . '/snapshot.jpg';
            $descriptionFilePath = Yii::getAlias('@templatePath/') . $t . '/README.md';
            $result[$t]['description'] = (file_exists($descriptionFilePath))? file_get_contents(Yii::getAlias('@templatePath/') . $t . '/README.md' ) : null;
        }

        return $result;
    }
}
