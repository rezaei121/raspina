<?php

namespace frontend\models;

use Yii;

/**
 *
 * @property string $search
 *
 */
class Site extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $search;
    public function rules()
    {
        return [
            [['search'], 'required'],
            [['search'], 'string', 'max' => 255],
            [['search'], 'safe']
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
