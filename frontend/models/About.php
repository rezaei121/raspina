<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%about}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $avatar
 * @property string $email
 * @property string $name
 * @property string $short_text
 * @property string $more_text
 * @property string $facebook
 * @property string $twitter
 * @property string $googleplus
 * @property string $instagram
 * @property string $linkedin
 *
 * @property User $user
 */
class About extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * get user about
     * @return array|null|\yii\db\ActiveRecord
     */
    public function get()
    {
        return $this->find()->asArray()->one();
    }
}
