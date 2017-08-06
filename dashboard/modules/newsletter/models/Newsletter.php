<?php

namespace dashboard\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "{{%newsletter}}".
 *
 * @property string $id
 * @property string $email
 * @property string $registered_at
 */
class Newsletter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['registered_at'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'registered_at' => Yii::t('app', 'Registered At'),
        ];
    }
}
