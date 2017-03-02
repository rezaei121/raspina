<?php

namespace frontend\models;

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
 * @property integer $create_time
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
    public $post_title;
    public $captcha;
    public function rules()
    {
        return [
            [['post_id','text','name'], 'required'],
            [['post_id', 'status','create_time'], 'integer'],
            [['text','reply_text'], 'string'],
            [['email'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 60],
            [['ip'], 'string', 'max' => 20],
            [['email'], 'email'],
            ['captcha', 'captcha'],
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
            'create_time' => Yii::t('app', 'Create Time'),
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
