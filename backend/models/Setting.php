<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property string $url
 * @property string $template
 * @property string $title
 * @property string $description
 * @property string $keyword
 * @property integer $page_size
 * @property string $date_format
 * @property string $sult
 */
class Setting extends \common\models\BaseModel
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
            [['url'], 'string', 'max' => 2000],
            [['template', 'title', 'description', 'date_format'], 'string', 'max' => 255],
            [['sult'], 'string', 'max' => 17],
            [['activation_newsletter'], 'boolean']
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
            'date_format' => Yii::t('app', 'Date Format'),
            'sult' => Yii::t('app', 'Sult'),
            'activation_newsletter' => Yii::t('app', 'Activation Newsletter')
        ];
    }

    public function getTemplatesName()
    {
        $dir = Yii::getAlias('@frontend/views/template/');
        $scandir = scandir($dir);
        $templatesName = [];
        foreach ((array) $scandir as $s)
        {
            if($s != '.' && $s != '..')
            {
                $templatesName[$s] = $s;
            }
        }
        return $templatesName;
    }
}
