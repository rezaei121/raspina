<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $name
 * @property string $email
 * @property string $text
 * @property integer $status
 * @property string $reply_text
 * @property string $created_at
 * @property string $ip
 *
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'name', 'email', 'text'], 'required'],
            [['post_id', 'status'], 'integer'],
            [['text', 'reply_text'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 20],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'reply_text' => Yii::t('app', 'Reply Text'),
            'created_at' => Yii::t('app', 'Created At'),
            'ip' => Yii::t('app', 'Ip'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
