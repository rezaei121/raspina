<?php

namespace app\modules\post\models\base;

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
class PostCategory extends \app\components\Model
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id'], 'required'],
            [['post_id', 'category_id'], 'integer'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
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
