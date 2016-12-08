<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "about".
 *
 * @property string $id
 * @property string $image
 * @property string $email
 * @property string $text
 */
class About extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['short_text','more_text'], 'string'],
            [['email'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 55],
            [['facebook','twitter','googleplus','instagram','linkedin'], 'string', 'max' => 1000],
            [['facebook','twitter','googleplus','instagram','linkedin'], 'url'],
            [['email'],'email'],
            [['avatar'],'image','extensions' => 'jpg']
        ];
    }

    public $image_upload;
    public function upload()
    {
        if ($this->validate() && RASPINA_ENV != 'demo')
        {
            $file_name = Yii::$app->user->id . '.jpg';
            $this->image_upload->saveAs(Yii::getAlias('@user_avatar') . '/' . $file_name);
            return $file_name;
        }
        else
        {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'avatar' => Yii::t('app', 'Profile Image'),
            'email' => Yii::t('app', 'Email'),
            'short_text' => Yii::t('app', 'Short Text'),
            'more_text' => Yii::t('app', 'More Text'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
