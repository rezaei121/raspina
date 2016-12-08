<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $message
 */
class Contact extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public $captcha;
    public function rules()
    {
        return [
            [['name', 'email', 'message'], 'required'],
            [['message'], 'string'],
            [['name'], 'string', 'max' => 75],
            [['email'], 'email'],
            [['site'], 'string', 'max' => 2000],
            [['ip'], 'string', 'max' => 20],
            ['captcha', 'captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site'),
            'message' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'ip' => Yii::t('app', 'IP'),
        ];
    }

    public function getContactStatus()
    {
        return [
            0 => Yii::t('app','Not Visited'),
            1 => Yii::t('app','Visited')
        ];
    }

    public function getCountNotVisited()
    {
        $query = new \yii\db\Query();
        return $query->select('id')->from($this->tableName())->where(['status' => 0])->count();
    }
}
