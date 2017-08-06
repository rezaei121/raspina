<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id
 * @property string $title
 * @property string $short_text
 * @property string $more_text
 * @property string $tags
 * @property string $keywords
 * @property string $meta_description
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $created_by
 * @property string $updated_by
 * @property integer $pin_post
 * @property integer $enable_comments
 * @property string $view
 *
 * @property Comment[] $comments
 * @property User $createdBy
 * @property User $updatedBy
 * @property PostCategory[] $postCategories
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_text'], 'required'],
            [['short_text', 'more_text', 'tags', 'keywords'], 'string'],
            [['status', 'created_by', 'updated_by', 'pin_post', 'enable_comments', 'view'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'meta_description'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
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
            'short_text' => Yii::t('app', 'Short Text'),
            'more_text' => Yii::t('app', 'More Text'),
            'tags' => Yii::t('app', 'Tags'),
            'keywords' => Yii::t('app', 'Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'pin_post' => Yii::t('app', 'Pin Post'),
            'enable_comments' => Yii::t('app', 'Enable Comments'),
            'view' => Yii::t('app', 'View'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }
}
