<?php
namespace backend\modules\newsletter\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property string $id
 * @property string $email
 */
class Newsletter extends \common\models\BaseModel
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
    public function rules()
    {
        return [
            [['email','title','text'], 'required'],
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

    public static function getCountMails()
    {
        return self::find()->count();
    }

    public function send($params)
    {
        $mails = $this->_getAllMails();
        if(!empty($mails) && RASPINA_ENV != 'demo')
        {
            $setting = Yii::$app->setting->get();
            $params['siteUrl'] = $setting['url'];
            $params['siteTitle'] = $setting['title'];
            $noReply = 'noreply@' . preg_replace('/http(s?):\/\/(www.)?/', null, Yii::$app->request->getHostInfo());
            foreach ((array)$mails as $email)
            {
                Yii::$app->mailer->compose('layouts/newsletter',$params)
                    ->setFrom($noReply)
                    ->setTo($email)
                    ->setSubject($params['title'] . ' - ' . $setting['title'])
                    ->send();
            }
            return true;
        }
        return false;
    }
}
