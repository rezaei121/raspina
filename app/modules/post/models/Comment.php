<?php
namespace app\modules\post\models;

use Yii;

class Comment extends \app\modules\post\models\base\Comment
{
    public $post_title;
    public $captcha;

    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules[] = ['reply_text', 'required','on' => 'reply'];
        $parentRules[] = ['captcha', 'captcha', 'on' => 'post-view'];
        return $parentRules;
    }

    public function attributeLabels()
    {
        $parentAttributeLabels = parent::attributeLabels();
        $parentAttributeLabels['post_title'] = Yii::t('app', 'In Post');
        $parentAttributeLabels['name'] = Yii::t('app', 'Sender');
        return $parentAttributeLabels;
    }

    public function getCommentStatus()
    {
        return [
            0 => Yii::t('app','Not Approved'),
            1 => Yii::t('app','Approved')
        ];
    }

    public static function getNotApprovedCount()
    {
        return self::find()->where(['status' => 0])->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id'])->alias('post');
    }
}
