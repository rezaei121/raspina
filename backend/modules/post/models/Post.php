<?php

namespace backend\modules\post\models;
use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $title
 * @property string $short_text
 * @property string $more_text
 * @property string $tags
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $author_id
 * @property string $keywords
 * @property string $send_newsletter
 *
 * @property PostCategory[] $postCategories
 */
class Post extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public $hour;
    public $minute;
    public $date;
    public $username;
    public $comment_count;
    public $more;
    public $post_id;
    public function rules()
    {
        return [
            [['title', 'short_text'], 'required'],
            [['title',], 'trim'],
            ['title', 'filter','filter' => function($value){
                return preg_replace('/\s+/',' ',str_replace(['/','\\'],' ',$value));
            }],
            [['short_text', 'more_text', 'tags','date'], 'string'],
            [['status', 'update_time', 'author_id','minute','hour','view','send_newsletter'], 'integer'],
            ['send_newsletter', 'default', 'value' => 0],
            [['title','meta_description'], 'string', 'max' => 255],
            [['hour','minute'], 'string', 'max' => 2],
            [['pin_post','comment_active'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'short_text' => Yii::t('app', 'Short Text'),
            'more_text' => Yii::t('app', 'More Text'),
            'tags' => Yii::t('app', 'Tags'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'author_id' => Yii::t('app', 'Author ID'),
            'hour' => Yii::t('app', 'Hour'),
            'minute' => Yii::t('app', 'Minute'),
            'date' => Yii::t('app', 'Date'),
            'pin_post' => Yii::t('app', 'Pin Post'),
            'keywords' => Yii::t('app', 'Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'view' => Yii::t('app', 'View Count'),
            'comment_active' => Yii::t('app', 'Comment Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id']);
    }

    public function afterSave($insert,$changedAttributes)
    {
        $selectedCategories = Yii::$app->request->post('post_categories');
        if(!empty($selectedCategories))
        {
            $data = [];

            foreach((array)$selectedCategories as $categoryId)
            {
                if($categoryId === null)
                {
                    continue;
                }

                $categoryModel = new \backend\modules\post\models\Category;

                if($categoryModel::findOne($categoryId) === null)
                {
                    $categoryModel->title = $categoryId;
                    $categoryModel->save();
                    $categoryId = $categoryModel->id;
                }

                if($categoryId !== null)
                {
                    $data[] = [$this->id,$categoryId];
                }
            }

            if(!empty($data))
            {
                PostCategory::deleteAll(['post_id'=>$this->id]);
                Yii::$app->db->createCommand()->batchInsert(PostCategory::tableName(),['post_id','category_id'],$data)->execute();
            }
        }

        if($insert && $this->status == 1 && $this->send_newsletter == 0)
        {
            $activation_newsletter = Yii::$app->setting->getValue('activation_newsletter');
            if($activation_newsletter == 1)
            {
                $newsletter = new \backend\modules\post\models\Newsletter();
                $newsletter->send([
                    'title' => $this->title,
                    'content' => $this->short_text,
                    'model' => $this
                ]);

                $this->send_newsletter = 1;
                $this->save();
            }
        }
    }

    public static function getSelectedCategoriesTitle($postId,$resultType = 'string')
    {
        $query = new \yii\db\Query;
        $postCategoryTableName = \backend\modules\post\models\PostCategory::tableName();
        $categoryTableName = \backend\modules\post\models\Category::tableName();

        $categories = $query->select("c.id,c.title")->from("{$postCategoryTableName} AS pc")->leftJoin("{$categoryTableName} AS c",'pc.category_id = c.id')->where(['pc.post_id' => $postId])->all();
        if($resultType == 'array')
        {
            return $categories;
        }

        $selectedCategories = \yii\helpers\ArrayHelper::getColumn($categories,function($element){
            return $element['title'];
        });
        return implode('، ',$selectedCategories);
    }

    public static function setSelect2Value($value,$oldValue)
    {
        $result = '';
        foreach((array)$value as $t)
        {
            if(is_numeric($t))
            {
                if(isset($oldValue[$t]))
                {
                    $result .= $oldValue[$t] . ',';
                }
                else
                {
                    $result .= $t . ',';
                }
            }
            else
            {
                $result .= $t . ',';
            }
        }
        return rtrim($result,',');
    }

    public function postStatus()
    {
        return [
            '0' => Yii::t('app','Draft'),
            '1' => Yii::t('app','Publish'),
            '2' => Yii::t('app','Send In Future'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }
}
