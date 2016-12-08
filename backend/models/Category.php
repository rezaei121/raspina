<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $title
 *
 * @property PostCategory[] $postCategories
 */
class Category extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'trim'],
            ['title', 'filter','filter' => function($value){
                return preg_replace('/\s+/',' ',str_replace(['/','\\'],' ',$value));
            }],
            [['title'], 'unique'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'title' => Yii::t('app','Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['category_id' => 'id']);
    }

    public static function getAllCategories()
    {
        $query = new \yii\db\Query();
        $query->select('*')->from(Category::tableName());
        $categories = $query->all();
        return \yii\helpers\ArrayHelper::map($categories,'id','title');
    }
}
