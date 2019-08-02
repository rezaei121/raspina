<?php
namespace app\modules\post\models;

use Yii;

class Comment extends \app\modules\post\models\base\BaseComment
{
    const NOT_APPROVED = 0;
    const APPROVED = 1;

    public $post_title;
    public $captcha;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['reply_text', 'required','on' => 'reply'];
        $rules[] = ['captcha', 'captcha', 'on' => 'post-view'];
        return $rules;
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['post_title'] = Yii::t('app', 'In Post');
        $attributeLabels['name'] = Yii::t('app', 'Sender');
        return $attributeLabels;
    }

    public function getCommentStatus()
    {
        return [
            $this::NOT_APPROVED => Yii::t('app','Not Approved'),
            $this::APPROVED => Yii::t('app','Approved')
        ];
    }

    public static function getNotApprovedCount()
    {
        return self::find()->where(['status' => self::NOT_APPROVED])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->alias('post');
    }
}
