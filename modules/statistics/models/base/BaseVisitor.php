<?php

namespace app\modules\statistics\models\base;

use Yii;

/**
 * This is the model class for table "rs_visitor".
 *
 * @property string $id
 * @property string $ip
 * @property string $visit_date
 * @property int $group_date
 * @property string $location
 * @property string $browser
 * @property string $browser_version
 * @property string $os
 * @property string $os_version
 * @property string $device
 * @property string $device_model
 * @property string $referer
 */
class BaseVisitor extends \app\components\Model
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rs_visitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_date'], 'safe'],
            [['group_date'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['location', 'referer'], 'string', 'max' => 2000],
            [['browser'], 'string', 'max' => 60],
            [['browser_version', 'os_version'], 'string', 'max' => 15],
            [['os', 'device', 'device_model'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'visit_date' => 'Visit Date',
            'group_date' => 'Group Date',
            'location' => 'Location',
            'browser' => 'Browser',
            'browser_version' => 'Browser Version',
            'os' => 'Os',
            'os_version' => 'Os Version',
            'device' => 'Device',
            'device_model' => 'Device Model',
            'referer' => 'Referer',
        ];
    }
}
