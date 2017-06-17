<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%visitors}}".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $visit_date
 * @property string $location
 * @property string $browser
 * @property string $os
 */
class Visitors extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */

    public static function isBot()
    {
        $botArrayName = [
            'googlebot' => 'Googlebot',
            'msnbot' => 'MSNBot',
            'MSNBot-Media' => 'MSNBot-Media',
            'bingbot' => 'Bingbot',
            'BingPreview' => 'BingPreview',
            'AdIdxBot' => 'AdIdxBot',
            'slurp' => 'Inktomi',
            'yahoo' => 'Yahoo',
            'askjeeves' => 'AskJeeves',
            'fastcrawler' => 'FastCrawler',
            'infoseek' => 'InfoSeek',
            'lycos' => 'Lycos',
            'yandex' => 'YandexBot',
            'geohasher' => 'GeoHasher',
            'gigablast' => 'Gigabot',
            'baidu' => 'Baiduspider',
            'spinn3r' => 'Spinn3r'
        ];

        if(isset($_SERVER['HTTP_USER_AGENT']))
        {
            foreach ($botArrayName as $bot)
            {
                $re = "/{$bot}/i";
                if(preg_match($re,$_SERVER['HTTP_USER_AGENT']))
                {
                    return $re;
                }
            }
        }
        return false;
    }

    public static function tableName()
    {
        return '{{%visitors}}';
    }

    public function add()
    {
        if(!$this::isBot())
        {
            $time = time();
            $visitor = new Visitors();
            $visitor->visit_date = $time;
            $visitor->group_date = (int)Yii::$app->date->pdate($time,'YMMdd');
            $visitor->ip = $_SERVER['REMOTE_ADDR'];
            $visitor->location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $visitor->browser = Yii::$app->browser->getBrowser() . ' ' . Yii::$app->browser->getVersion();
            $visitor->os = Yii::$app->browser->getPlatform();
            $visitor->referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
            $visitor->save();
        }
    }

    public function delete()
    {
        $date = strtotime('-30 day');
        Visitors::deleteAll("visit_date < {$date}");
    }

    public function visit_period()
    {
        $query = new Yii\db\Query();
        $v1 = $query->select('COUNT(id)')->where("DATE_FORMAT(FROM_UNIXTIME(visit_date), '%H') BETWEEN 00 AND 06 ")->from($this->tableName())->scalar();
        $v2 = $query->select('COUNT(id)')->where("DATE_FORMAT(FROM_UNIXTIME(visit_date), '%H') BETWEEN 07 AND 12 ")->from($this->tableName())->scalar();
        $v3 = $query->select('COUNT(id)')->where("DATE_FORMAT(FROM_UNIXTIME(visit_date), '%H') BETWEEN 13 AND 18 ")->from($this->tableName())->scalar();
        $v4 = $query->select('COUNT(id)')->where("DATE_FORMAT(FROM_UNIXTIME(visit_date), '%H') BETWEEN 19 AND 24 ")->from($this->tableName())->scalar();
        return "[{$v1},{$v2},{$v3},{$v4}]";
    }

    public function pie_chart()
    {
        $query = new Yii\db\Query();
        $google = $query->select('COUNT(id)')->where("referer LIKE '%google.com%'")->from($this->tableName())->scalar();
        $yahoo = $query->select('COUNT(id)')->where("referer LIKE '%yahoo.com%'")->from($this->tableName())->scalar();
        $bing = $query->select('COUNT(id)')->where("referer LIKE '%bing.com%'")->from($this->tableName())->scalar();
        $baidu = $query->select('COUNT(id)')->where("referer LIKE '%baidu.com%'")->from($this->tableName())->scalar();
        $aol = $query->select('COUNT(id)')->where("referer LIKE '%aol.com%'")->from($this->tableName())->scalar();
        $asc = $query->select('COUNT(id)')->where("referer LIKE '%ask.com%'")->from($this->tableName())->scalar();
        return "[{$google},{$yahoo},{$bing},{$baidu},{$aol},{$asc}]";
    }

    public function chart()
    {
        $date = strtotime('-30 day');
        $visitor = new Yii\db\Query();
        $result = $visitor->select('visit_date,group_date,COUNT(id) as `visit`,COUNT(DISTINCT ip) AS `visitor`')->from($this->tableName())->where('visit_date >= ' . $date)->groupBy('group_date')->all();

        $labels = $visit_data = $visitor_data = [];
        $max_visit = 0;
        $this_month_visitors = $this_month_visit = 0;
        foreach ((array)$result as $r)
        {
            $labels[] = "'" . Yii::$app->date->pdate($r['visit_date'],'YY/MM/dd') . "'";
            $visit_data[] = "'" . $r['visit'] . "'";
            $visitor_data[] = "'" . $r['visitor'] . "'";

            if( $r['visit'] > $max_visit)
            {
                $max_visit = $r['visit'];
            }
            $this_month_visit += $r['visit'];
            $this_month_visitors += $r['visitor'];
        }

        $labels = '[' . implode(',',$labels) . ']';
        $visit_data = '[' . implode(',',$visit_data) . ']';
        $visitor_data = '[' . implode(',',$visitor_data) . ']';

        $today_visitors = $today_visit = 0;
        $result_count = count($result) - 1;
        if(!empty($result[$result_count]))
        {
            $today_visitors = $result[$result_count]['visitor'];
            $today_visit = $result[$result_count]['visit'];
        }

        $yesterday_visitors = $yesterday_visit = 0;
        if(!empty($result[$result_count-1]))
        {
            $yesterday_visitors = $result[$result_count-1]['visitor'];
            $yesterday_visit = $result[$result_count-1]['visit'];
        }

        $chart = [
            'labels' => $labels,
            'max_visit' => $max_visit,
            'visit' => ['title' => Yii::t('app','Visit'), 'data' => $visit_data],
            'visitor' => ['title' => Yii::t('app','Visitor'), 'data' => $visitor_data],
            'today_visitors' => (int)$today_visitors,
            'today_visit' => (int)$today_visit,
            'yesterday_visitors' => (int)$yesterday_visitors,
            'yesterday_visit' => (int)$yesterday_visit,
            'this_month_visitors' => $this_month_visitors,
            'this_month_visit' => $this_month_visit
        ];
        return $chart;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_date','group_date'], 'integer'],
            [['ip'], 'string', 'max' => 15],
            [['browser'], 'string', 'max' => 60],
            [['location'], 'string', 'max' => 1000],
            [['os'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'visit_date' => Yii::t('app', 'Visit Date'),
            'location' => Yii::t('app', 'Location'),
            'browser' => Yii::t('app', 'Browser'),
            'os' => Yii::t('app', 'OS')
        ];
    }
}
