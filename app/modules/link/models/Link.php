<?php

namespace app\modules\link\models;

use Yii;

class Link extends \app\modules\link\models\base\Link
{
    public static function getAll()
    {
        return self::find()->all();
    }
}
