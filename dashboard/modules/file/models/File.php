<?php

namespace dashboard\modules\file\models;

use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property string $id
 * @property string $name
 * @property string $size
 * @property string $extension
 * @property string $content_type
 * @property string $uploaded_at
 * @property string $uploaded_by
 * @property string $real_name
 * @property string $download_count
 *
 * @property User $uploadedBy
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'size', 'extension', 'content_type', 'uploaded_by', 'real_name'], 'required'],
            [['size', 'uploaded_by', 'download_count'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['name', 'real_name'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 4],
            [['content_type'], 'string', 'max' => 55],
            [['uploaded_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uploaded_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'size' => Yii::t('app', 'Size'),
            'extension' => Yii::t('app', 'Extension'),
            'content_type' => Yii::t('app', 'Content Type'),
            'uploaded_at' => Yii::t('app', 'Uploaded At'),
            'uploaded_by' => Yii::t('app', 'Uploaded By'),
            'real_name' => Yii::t('app', 'Real Name'),
            'download_count' => Yii::t('app', 'Download Count'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }
}
