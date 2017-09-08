<?php

namespace dashboard\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "{{%newsletter}}".
 *
 * @property string $id
 * @property string $email
 * @property string $registered_at
 */
class Newsletter extends \common\models\Newsletter
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%newsletter}}';
    }

    /**
     * @inheritdoc
     */
    public $title;
    public $text;
    public $mail;
    public $emails;
    public $template;
    public function rules()
    {
        $parentRules = parent::rules();
        $parentRules[] = [['email','title','text', 'template'], 'required'];
        $parentRules[] = [['email','title'], 'string', 'max' => 255];
        $parentRules[] = [['text'], 'string'];
        return $parentRules;
    }

    public function attributeLabels()
    {
        $parentAttributeLabels = parent::attributeLabels();
        $parentAttributeLabels['title'] = Yii::t('app', 'Title');
        $parentAttributeLabels['text'] = Yii::t('app', 'Text');
        $parentAttributeLabels['template'] = Yii::t('app', 'Template');
        return $parentAttributeLabels;
    }

    public function getAllMails()
    {
        $model = Newsletter::find()->asArray()->all();
        $mails = [];
        foreach ((array)$model as $m)
        {
            $mails[$m['email']] = $m['email'];
        }

        return $mails;
    }

    public static function getCountMails()
    {
        return self::find()->count();
    }

    public function send($emails)
    {
        if(empty($emails))
        {
            return false;
        }

        $setting = Yii::$app->setting->get();
        $params['title'] = $this->title;
        $params['content'] = $this->text;
        $params['siteUrl'] = $setting['url'];
        $params['siteTitle'] = $setting['title'];
        $noReply = 'noreply@' . preg_replace('/http(s?):\/\/(www.)?/', null, Yii::$app->request->getHostInfo());

        $emails = ['mr.rezaee121@gmail.com'];
        foreach ((array)$emails as $email)
        {
            Yii::$app->mailer->compose('layouts/newsletter',$params)
                ->setFrom($noReply)
                ->setTo($email)
                ->setSubject($params['title'] . ' - ' . $setting['title'])
                ->send();
        }
        return true;
    }
}
