<?php
namespace dashboard\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property string $id
 * @property string $email
 */
class Newsletter extends \yii\db\ActiveRecord
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
        return [
            [['email','title','text', 'template'], 'required'],
            [['email','title'], 'string', 'max' => 255],
            [['text'], 'string'],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'template' => Yii::t('app', 'Template'),
        ];
    }

    private function _getAllMails()
    {
        $model = Newsletter::find()->all();

        $mails = \yii\helpers\ArrayHelper::getColumn($model,function($element){
            return $element['email'];
        });

        return $mails;
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
