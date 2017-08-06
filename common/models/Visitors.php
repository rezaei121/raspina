<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%visitors}}".
 *
 * @property string $id
 * @property string $ip
 * @property string $visit_date
 * @property integer $group_date
 * @property string $location
 * @property string $browser
 * @property string $os
 * @property string $referer
 * @property string $user_agent
 */
class Visitors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visitors}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_date'], 'safe'],
            [['group_date'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['location', 'referer', 'user_agent'], 'string', 'max' => 2000],
            [['browser'], 'string', 'max' => 60],
            [['os'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'visit_date' => Yii::t('app', 'Visit Date'),
            'group_date' => Yii::t('app', 'Group Date'),
            'location' => Yii::t('app', 'Location'),
            'browser' => Yii::t('app', 'Browser'),
            'os' => Yii::t('app', 'Os'),
            'referer' => Yii::t('app', 'Referer'),
            'user_agent' => Yii::t('app', 'User Agent'),
        ];
    }
}
