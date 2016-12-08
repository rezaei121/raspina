<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "about".
 *
 * @property string $id
 * @property string $image
 * @property string $email
 * @property string $text
 */
class BaseModel extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if(RASPINA_ENV == 'demo')
        {
            Yii::$app->session->setFlash('error', Yii::t('app','Cannot Create, Update Or Delete Contens'));
            return false;
        }
        return true;
    }

    public function beforeDelete()
    {
        if(RASPINA_ENV == 'demo')
        {
            Yii::$app->session->setFlash('error', Yii::t('app','Cannot Create, Update Or Delete Contens'));
            return false;
        }
        return true;
    }
}
