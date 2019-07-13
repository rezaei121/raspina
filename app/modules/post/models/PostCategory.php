<?php
namespace app\modules\post\models;

use Yii;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property string $id
 * @property string $post_id
 * @property string $category_id
 *
 * @property Post $post
 * @property Category $category
 */
class PostCategory extends \app\modules\post\models\base\PostCategory
{
    public static function getSelectedCategories($postId)
    {
        $selectedCategories = [];
        $categories = self::findAll(['post_id' => $postId]);
        $selectedCategories = \yii\helpers\ArrayHelper::getColumn($categories,function($element){
            return $element['category_id'];
        });
        return $selectedCategories;
    }
}
