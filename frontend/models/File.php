<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $size
 * @property string $extension
 * @property string $content_type
 * @property integer $upload_date
 * @property integer $user_id
 * @property string $real_name
 * @property integer $download_count
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }
}
