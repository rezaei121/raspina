<?php
namespace backend\modules\post\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $id
 * @property string $post_id
 * @property string $email
 * @property string $text
 * @property integer $status
 *
 * @property Post $post
 */
class Comment extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    public $post_title;
    public function rules()
    {
        return [
            ['reply_text', 'required','on' => 'comment-reply']
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
            'post_title' => Yii::t('app', 'Post Title'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'reply_text' => Yii::t('app', 'Reply'),
            'create_time' => Yii::t('app', 'Create Time'),
            'ip' => Yii::t('app', 'IP'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(\backend\modules\post\models\Post::className(), ['id' => 'post_id'])->from(['post' => \backend\modules\post\models\Post::tableName()]);
    }

    public function getCommentStatus()
    {
        return [
            0 => Yii::t('app','Not Accepted'),
            1 => Yii::t('app','Accepted')
        ];
    }

    public static function getCountNotAccepted()
    {
        return self::find()->where(['status' => 0])->count();
    }
}
