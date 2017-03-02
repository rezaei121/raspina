<?php
namespace frontend\models;
use common\models\User;
use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_text
 * @property string $more_text
 * @property string $tags
 * @property string $keywords
 * @property string $meta_description
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 * @property integer $pin_post
 * @property integer $comment_active
 * @property integer $view
 * @property integer $send_newsletter
 *
 * @property Comment[] $comments
 * @property PostCategory[] $postCategories
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id'])->where(['status' => 1])->orderBy(['id' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategories()
    {
        return $this->hasMany(PostCategory::className(), ['post_id' => 'id'])->joinWith('category')->asArray();
    }

    /**
     * plus view count
     * @throws \yii\db\Exception
     */
    public function plusView()
    {
        if(!\common\models\Visitors::isBot())
        {
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
        $posTable = Post::tableName();
        $userTable = \common\models\User::tableName();
        $commentTable = \frontend\models\Comment::tableName();

        $model = new \yii\db\Query();
        $model->select(["p.*","u.last_name","u.surname","COUNT(c.id) AS comment_count","IF(p.more_text IS NOT NULL,'1','0') AS `more`"])->
        from("{$posTable} As p")->leftJoin("{$userTable} AS u","p.author_id = u.id")->
        leftJoin("{$commentTable} AS c","p.id = c.post_id  AND c.status = 1")->
        where(['p.id' => $this->id, 'p.title' => $this->title, 'p.status' => 1]);

        return $model->one();
    }

    /**
     * get related post
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelated()
    {
        $title = explode(' ',$this->title);
        $likes = [];
        foreach ($title as $t)
        {
            $likes[] = "(title LIKE '%{$t}%')";
        }
        $sql = "
            SELECT p.*,
                   (" . implode(' + ', $likes) . ") as hits
            FROM rs_post AS p
            WHERE p.id != {$this->id} AND p.status = 1
            HAVING hits > 0
            ORDER BY hits DESC
            LIMIT 5
        ";
        return $this->findBySql($sql);
    }
}
