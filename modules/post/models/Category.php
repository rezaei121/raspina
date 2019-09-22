<?php
namespace app\modules\post\models;

use Yii;
use app\components\behaviors\SluggableBehavior;


class Category extends \app\modules\post\models\base\BaseCategory
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => SluggableBehavior::className(),
            'attribute' => 'title',
        ];
        return $behaviors;
    }

    public function beforeValidate()
    {
        $this->created_by = Yii::$app->user->id;
        return parent::beforeValidate();
    }

    public static function getAll()
    {
        return self::find()->select(['id', 'title', 'slug'])->asArray()->all();
    }

    public static function getCategories()
    {
        $categories = Category::find()->all();
        $result = \yii\helpers\ArrayHelper::getColumn($categories,function($element){
            return [
                'id' => $element['id'],
                'title' => $element['title'],
                'slug' => $element['slug'],
            ];
        });

        return $result;
    }
}
