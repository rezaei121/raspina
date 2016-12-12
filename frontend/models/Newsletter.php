<?php

namespace frontend\models;

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
    public $captcha;
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique','on' => 'join'],
            ['captcha', 'captcha','on' => 'unsubscribe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }

    public function getMail($email)
    {
        $mail = Newsletter::find()->where(['email' => $email])->one();
        return $mail;
    }
}
