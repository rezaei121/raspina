<?php

namespace app\modules\setting\models\base;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property string $id
 * @property string $url
 * @property string $template
 * @property string $title
 * @property string $description
 * @property string $keyword
 * @property integer $page_size
 * @property string $language
 * @property string $direction
 * @property string $time_zone
 * @property string $date_format
 * @property string $sult
 */
class BaseSetting extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'template', 'title'], 'required'],
            [['keyword'], 'string'],
            [['page_size'], 'integer'],
            [['url', 'template', 'title', 'description'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 12],
            [['direction'], 'string', 'max' => 3],
            [['time_zone'], 'string', 'max' => 25],
            [['date_format'], 'string', 'max' => 55],
            [['sult'], 'string', 'max' => 17],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'template' => Yii::t('app', 'Template'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'keyword' => Yii::t('app', 'Keyword'),
            'page_size' => Yii::t('app', 'Page Size'),
            'language' => Yii::t('app', 'Language'),
            'direction' => Yii::t('app', 'Direction'),
            'time_zone' => Yii::t('app', 'Time Zone'),
            'date_format' => Yii::t('app', 'Date Format'),
            'sult' => Yii::t('app', 'Sult'),
        ];
    }
}
