<?php

namespace dashboard\modules\contact\models;

use Yii;

class Contact extends \common\models\Contact
{
    public function getStatusList()
    {
        return [
            0 => Yii::t('app','Not viewed'),
            1 => Yii::t('app','Viewed')
        ];
    }

    public static function getNotViewedCount()
    {
        return self::find()->where(['status' => 0])->count();
    }
}
