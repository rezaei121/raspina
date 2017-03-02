<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%post_category}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $category_id
 *
 * @property Post $post
 * @property Category $category
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
