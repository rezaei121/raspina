<?php

namespace dashboard\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "{{%newsletter_log}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $text
 * @property string $sent_at
 *
 * @property User $user
 */
class NewsletterLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'text'], 'required'],
            [['user_id'], 'integer'],
            [['text'], 'string'],
            [['sent_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'sent_at' => Yii::t('app', 'Sent At'),
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
