<?php

namespace dashboard\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "{{%newsletter_log}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $sent_at
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
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['sent_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'sent_at' => Yii::t('app', 'Sent At'),
        ];
    }
}
