<?php

namespace frontend\models;

use Yii;

class Contact extends \common\models\Contact
{
    /**
     * @inheritdoc
     */
    public $captcha;
    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules[] = ['captcha', 'captcha'];
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
