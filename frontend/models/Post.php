<?php
namespace frontend\models;
use frontend\models\Comment;
use common\models\PostCategory;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\Url;


class Post extends \common\models\Post
{
    public $comment_count;
    public $category_ids;
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])
            ->alias('c')
            ->where(['c.status' => 1])
            ->joinWith('createdBy')
            ->orderBy(['c.id' => SORT_DESC]);
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
        if (!\common\models\Visitors::isBot()) {
            $this->view++;
            $this->save(false);
        }
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
    public function related()
    {
        $title = explode(' ',$this->title);
        $likes = [];
        foreach ($title as $t)
        {
            $likes[] = "(p.title LIKE '%{$t}%')";
        }
        $likes[] = "(IFNULL(t.title LIKE '%{$t}%',0))";
        $likes[] = "(IFNULL(p.keywords LIKE '%{$t}%',0))";

        $sql = "
            SELECT p.*,
                   (" . implode(' + ', $likes) . ") as hits
            FROM rs_post AS p
            LEFT JOIN rs_post_tag pt on pt.post_id = p.id
            LEFT JOIN rs_tag t on pt.tag_id = t.id
            WHERE p.id != {$this->id} AND p.status = 1
            HAVING hits > 0
            ORDER BY hits DESC
            LIMIT 5
        ";
        return $this->findBySql($sql)->all();
    }

    public function url()
    {
        return Url::to([0 => 'post/view','id' => $this->id,'title' => $this->title]);
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
        return Url::to(['/user/about', 'username' => $this->createdBy->username]);
    }

    public function updaterAuthorUrl()
    {
        return Url::to(['/user/about', 'username' => $this->updatedBy->username]);
    }
}
