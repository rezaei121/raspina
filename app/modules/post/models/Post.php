<?php
namespace app\modules\post\models;
use app\components\behaviors\SluggableBehavior;
use app\modules\post\models\base\BasePostTag;
use app\modules\post\models\base\BaseTag;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Post extends \app\modules\post\models\base\BasePost
{
    const DRAFT_STATUS = 0;
    const PUBLISH_STATUS = 1;

    /**
     * @inheritdoc
     */
    public $comment_count;
    public $more;
    public $tags;
    public $post_id;
    public $auto_save = true;
    public $search;

    public $count;
    public $sum;

    public function behaviors()
    {
        $behaviors = [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
        ];
       return array_merge($behaviors, parent::behaviors());
    }

    public function rules()
    {
        $parentRules = parent::rules();

        $parentRules[] = [['title'], 'trim'];
        $parentRules[] = ['title', 'filter','filter' => function($value){
            return preg_replace('/\s+/',' ',str_replace(['/','\\'],' ',$value));
        }];
        $parentRules[] = [['pin_post', 'enable_comments'], 'boolean'];
        return $parentRules;
    }

    public function load($data, $formName = null)
    {
        $request = Yii::$app->request->post();
        $this->keywords = (isset($request['keywords']) && !empty($request['keywords'])) ? implode(',', $request['keywords']) : null;
        return parent::load($data, $formName); // TODO: Change the autogenerated stub
    }

    public function beforeSave($insert)
    {
        if($insert)
        {
            $this->created_by = Yii::$app->user->id;
        }

        if(!$insert)
        {
            $this->updated_by = Yii::$app->user->id;
            $this->updated_at = (new \DateTime())->format('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $parentAttributeLabels = parent::attributeLabels();
        $parentAttributeLabels['auto_save'] = Yii::t('app', 'Auto save as draft');
        $parentAttributeLabels['date'] = Yii::t('app', 'Date');
        $parentAttributeLabels['hour'] = Yii::t('app', 'Hour');
        $parentAttributeLabels['minute'] = Yii::t('app', 'Minute');
        return $parentAttributeLabels;
    }

    public function afterSave($insert,$changedAttributes)
    {
        // insert Categories
        $selectedCategories = Yii::$app->request->post('post_categories');
        if($selectedCategories !== null)
        {
            $data = [];
            foreach((array)$selectedCategories as $categoryId)
            {
                if($categoryId != '' && Category::findOne($categoryId) === null)
                {
                    $categoryModel = new Category;
                    $categoryModel->title = $categoryId;
                    $categoryModel->save();
                    $categoryId = $categoryModel->id;
                }

                if($categoryId != '')
                {
                    $data[] = [$this->id, $categoryId];
                }
            }

            if(!empty($data))
            {
                PostCategory::deleteAll(['post_id' => $this->id]);
                Yii::$app->db->createCommand()->batchInsert(PostCategory::tableName(), ['post_id', 'category_id'], $data)->execute();
            }
        }

        // insert tags
        $tags = Yii::$app->request->post('tags');
        if(!empty($tags))
        {
            $data = [];
            foreach((array)$tags as $t)
            {
                $tagId = null;
                if($t != '')
                {
                    $exists = BaseTag::findOne(['title' => $t]);
                    if($exists !== null)
                    {
                        $tagId = $exists->id;
                    }
                    else
                    {
                        $tagModel = new BaseTag;
                        $tagModel->title = $t;
                        $tagModel->save();
                        $tagId = $tagModel->id;
                    }
                }

                if($tagId !== null)
                {
                    $data[] = [$this->id, $tagId];
                }

            }

            if(!empty($data))
            {
                BasePostTag::deleteAll(['post_id' => $this->id]);
                Yii::$app->db->createCommand()->batchInsert(BasePostTag::tableName(), ['post_id', 'tag_id'], $data)->execute();
            }
        }
    }

    public function getSelectedCategoriesTitle($resultType = 'string')
    {
        $query = new \yii\db\Query;
        $categories = $query->select("c.id,c.title")->from(['pc' => PostCategory::tableName()])->leftJoin(['c' => Category::tableName()], 'pc.category_id = c.id')->where(['pc.post_id' => $this->id])->all();

        if($resultType == 'array')
        {
            return $categories;
        }

        $selectedCategories = \yii\helpers\ArrayHelper::getColumn($categories,function($element){
            return $element['title'];
        });
        return implode(', ',$selectedCategories);
    }

    public function getSelectedTags()
    {
        $result = $this->hasMany(BasePostTag::className(), ['post_id' => 'id'])
            ->select('t.*')
            ->alias('pt')
            ->innerJoin(['t' => BaseTag::tableName()], 'pt.tag_id = t.id')
            ->all();

        return \yii\helpers\ArrayHelper::map($result,'title','title');
    }

    public function getSelectedKeywords()
    {
        $newValue = [];
        if($this->id)
        {
            $model = Post::findOne($this->id);
            $value = explode(',', $model->keywords);
            foreach ((array)$value as $v)
            {
                if(!empty($v))
                {
                    $newValue[$v] = $v;
                }
            }
        }
        return $newValue;
    }

    public function postStatus()
    {
        return [
            $this::DRAFT_STATUS => Yii::t('app','Draft'),
            $this::PUBLISH_STATUS => Yii::t('app','Publish'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id'])->joinWith('category');
    }

    /**
     * plus view count
     * @throws \yii\db\Exception
     */
    public function plusView()
    {
        $this->view++;
        $this->save(false);
    }

    /**
     * get a post with all details
     * @return array|bool
     */
    public function get()
    {
        $commentTable = \frontend\models\Comment::tableName();

        $model = Post::find()
            ->alias('p')
            ->select(['p.*', 'COUNT(c.id) comment_count'])
            ->innerJoinWith('createdBy u1')
            ->joinWith('updatedBy u2')
            ->leftJoin(['c' => $commentTable], "p.id = c.post_id  AND c.status = 1 AND c.post_id = {$this->id}")
            ->where(['p.id' => $this->id]);
        return $model->one();
    }

    public function tags()
    {
        return parent::getPostTags();
    }

    public function comments()
    {
        return $this->getComments()->all();
    }

    public function categories()
    {
        return $this->getPostCategories()->all();
    }

    /**
     * get related post
     * @return array|\yii\db\ActiveRecord[]
     */
    public function suggest()
    {
        $postCategories = ArrayHelper::getColumn($this->postCategories, function($element){
            return $element['category_id'];
        });

        return Post::find()
            ->alias('p')
            ->select(['p.id', 'p.title', 'p.slug'])
            ->joinWith(['postCategories' => function (ActiveQuery $query) {
                $query->alias('pc');
            }], false)
            ->where(['and',
                ['p.status' => Post::PUBLISH_STATUS],
                ['pc.category_id' => $postCategories],
                ['!=', 'p.id', $this->id]
            ])
            ->orderBy(['view' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    public function url()
    {
        return Url::to(['/post/default/view','id' => $this->id,'title' => $this->slug]);
    }

    public function author()
    {
        return "{$this->createdBy->last_name} {$this->createdBy->surname}";
    }

    public function updaterAuthor()
    {
        if($this->updatedBy !== null)
        {
            return "{$this->updatedBy->last_name} {$this->updatedBy->surname}";
        }

        return null;
    }

    public function authorUrl()
    {
        return Url::to(['/user/default/about', 'username' => $this->createdBy->username]);
    }

    public function updaterAuthorUrl()
    {
        return Url::to(['/user/about', 'username' => $this->updatedBy->username]);
    }

    public static function getAll($request = null)
    {
        $postsModel = Post::find()
            ->alias('post')
            ->select(['post.id', 'post.title', 'post.slug', 'post.short_text', 'post.created_at', 'post.updated_at', 'post.created_by', 'post.updated_by', 'post.pin_post', 'post.view', 'post.more_text', 'comment_count' => 'COUNT(post_comment.id)'])
            ->joinWith(['createdBy' => function (ActiveQuery $query) {
                $query->alias('created_by');
                $query->select(['created_by.id', 'created_by.last_name', 'created_by.surname']);
            }])
            ->joinWith(['updatedBy' => function (ActiveQuery $query) {
                $query->alias('updated_by');
                $query->select(['updated_by.id', 'updated_by.last_name', 'updated_by.surname']);
            }])
            ->joinWith(['comments' => function (ActiveQuery $query) {
                $query->alias('post_comment');
                $query->onCondition(['post_comment.status' => self::PUBLISH_STATUS]);
            }])
            ->joinWith(['postCategories' => function (ActiveQuery $query) {
                $query->alias('post_categories');
                $query->select(['post_categories.category_id', 'post_categories.post_id']);
                $query->joinWith(['category' => function (ActiveQuery $query) {
                    $query->alias('category');
                    $query->select(['category.id', 'category.title', 'category.slug']);
                }]);
            }])
            ->groupBy('post.id')
            ->orderBy(['post.pin_post' => SORT_DESC, 'post.id' => SORT_DESC])
            ->where(['post.status' => self::PUBLISH_STATUS]);

        if(isset($request['category']))
        {
            $postsModel->andWhere(['post_categories.category_id' => $request['category']]);
        }

        if(isset($request['tag']))
        {
            $postsModel->joinWith(['postTags' => function (ActiveQuery $query) use($request){
                $query->alias('post_tags');
                $query->select(['post_tags.tag_id', 'post_tags.post_id']);
                $query->joinWith(['tag' => function (ActiveQuery $query) use($request){
                    $query->alias('tag');
                    $query->select(['tag.id', 'tag.title', 'tag.slug']);
                    $query->onCondition(['tag.slug' => $request['tag']]);
                }]);
            }]);
        }

        if(isset($request['Post']['search']) && !empty($request['Post']['search']))
        {
            $postsModel->andWhere(['like','post.title', $request['Post']['search']]);
            $postsModel->orWhere(['like','post.short_text', $request['Post']['search']]);
            $postsModel->orWhere(['like','post.more_text', $request['Post']['search']]);
        }

        return $postsModel;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostTags()
    {
        $result = $this->hasMany(BasePostTag::className(), ['post_id' => 'id'])
            ->select('t.*')
            ->alias('pt')
            ->innerJoin(['t' => BaseTag::tableName()], 'pt.tag_id = t.id')
            ->asArray()
            ->all();
        return \yii\helpers\ArrayHelper::map($result,'title','slug');
    }
}
