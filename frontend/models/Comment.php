<?php

namespace frontend\models;

use Yii;


class Comment extends \common\models\Comment
{
    /**
     * @inheritdoc
     */
    public $post_title;
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
