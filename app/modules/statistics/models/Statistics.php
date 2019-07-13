<?php
namespace app\modules\statistics\models;

use app\modules\post\models\Category;
use app\modules\post\models\Post;
use app\modules\post\models\PostCategory;
use Yii;
use yii\data\ActiveDataProvider;

class Statistics extends \yii\db\ActiveRecord
{
    public function getPostCount()
    {
        return (int)Post::find()->count();
    }

    public function getPostViews()
    {
        return (int)Post::find()->sum('view');
    }

    public function getAlexaRank()
    {
        $url = Yii::$app->setting->getValue('url');
        $xml = simplexml_load_file('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);
        $globalRank = isset($xml->SD[1]->POPULARITY)?$xml->SD[1]->POPULARITY->attributes()->TEXT:0;
        $countryRank = isset($xml->SD[1]->COUNTRY)?$xml->SD[1]->COUNTRY->attributes()->RANK:0;

        return [
            'global' => number_format((string)$globalRank),
            'country' => number_format((string)$countryRank)
        ];
    }

    public function getPostsDetailGroupByCategories()
    {
        $query = Post::find()
            ->alias('p')
            ->select(['c.title', 'count' => 'COUNT(p.id)', 'sum' => 'SUM(p.view)'])
            ->leftJoin(['pc' => PostCategory::tableName()], 'p.id = pc.post_id')
            ->leftJoin(['c' => Category::tableName()], 'c.id = pc.category_id')
            ->groupBy('c.id')
            ->orderBy('sum DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
        return $dataProvider;
    }

    public function getTopPosts()
    {
        $query = Post::find()->where(['>', 'view', 0])->orderBy(['view' => SORT_DESC])->limit(10);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        return $dataProvider;
    }
}
