<?php

namespace dashboard\modules\about\models;

use Yii;

/**
 * This is the model class for table "{{%about}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $email
 * @property string $name
 * @property string $short_text
 * @property string $more_text
 * @property string $facebook
 * @property string $twitter
 * @property string $googleplus
 * @property string $instagram
 * @property string $linkedin
 *
 * @property User $user
 */
class About extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['short_text', 'more_text'], 'string'],
            [['email', 'facebook', 'twitter', 'googleplus', 'instagram', 'linkedin'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 55],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'email' => Yii::t('app', 'Email'),
            'name' => Yii::t('app', 'Name'),
            'short_text' => Yii::t('app', 'Short Text'),
            'more_text' => Yii::t('app', 'More Text'),
            'facebook' => Yii::t('app', 'Facebook'),
            'twitter' => Yii::t('app', 'Twitter'),
            'googleplus' => Yii::t('app', 'Googleplus'),
            'instagram' => Yii::t('app', 'Instagram'),
            'linkedin' => Yii::t('app', 'Linkedin'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
