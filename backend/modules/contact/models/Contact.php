<?php

namespace backend\modules\contact\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $message
 * @property string $status
 */
class Contact extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site'),
            'message' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'ip' => Yii::t('app', 'IP'),
        ];
    }

    public function getContactStatus()
    {
        return [
            0 => Yii::t('app','Not Visited'),
            1 => Yii::t('app','Visited')
        ];
    }

    public static function getCountNotVisited()
    {
        return self::find()->where(['status' => 0])->count();
    }
}
