<?php

namespace frontend\models;

use Yii;

/**
 *
 * @property string $search
 *
 */
class Site extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public $search;
    public function rules()
    {
        return [
            [['search'], 'required'],
            [['search'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'search' => Yii::t('app', 'Search'),
        ];
    }
}
