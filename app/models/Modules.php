<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modules".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property string $icon
 * @property int $status
 * @property int $type
 */
class Modules extends \yii\db\ActiveRecord
{
    const DEACTIVE = 0;
    const ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%modules}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'icon'], 'required'],
            [['status', 'type'], 'integer'],
            [['name', 'icon'], 'string', 'max' => 80],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'icon' => 'Icon',
            'status' => 'Status',
            'type' => 'Type',
        ];
    }
}
