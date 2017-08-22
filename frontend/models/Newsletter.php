<?php

namespace frontend\models;

use Yii;


class Newsletter extends \common\models\Newsletter
{
    /**
     * @inheritdoc
     */
    public $captcha;
    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules[] = ['captcha', 'captcha', 'on' => 'unsubscribe'];
        return $parentRules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $parentAttributeLabels = parent::attributeLabels();
        $parentAttributeLabels['captcha'] = Yii::t('app', 'Captcha');
        return $parentAttributeLabels;
    }
}
