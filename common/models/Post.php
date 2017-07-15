<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_text
 * @property string $more_text
 * @property string $tags
 * @property string $keywords
 * @property string $meta_description
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $author_id
 * @property integer $pin_post
 * @property integer $enable_comments
 * @property integer $view
 *
 * @property Comment[] $comments
 * @property User $author
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
            [['status', 'author_id', 'pin_post', 'enable_comments', 'view'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'meta_description'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
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
            'author_id' => Yii::t('app', 'Author ID'),
            'pin_post' => Yii::t('app', 'Pin Post'),
            'enable_comments' => Yii::t('app', 'Enable Comments'),
            'view' => Yii::t('app', 'View')
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
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }
}
