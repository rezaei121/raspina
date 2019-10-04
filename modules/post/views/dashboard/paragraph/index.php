<?php
use yii\grid\GridView;
use app\components\helpers\Html;

/* @var $model dashboard\modules\post\models\Post */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];

?>

<?= Html::beginPanel($this->title) ?>
<?php

foreach ($result as $r)
{
    echo "<h4 style='font-size: 16px; font-weight: bold'>{$r['title']}</h4><br>";
    foreach ($r['paragraphs'] as $k => $paragraph)
    {
        $pId = $k + 1;
        echo '<div style="font-size: 14px; ">';
        echo "<h5 style='font-weight: bold; color: #D1780A'># پاراگراف ($pId)</h5><br>";
        echo '<div style="border-right: 5px solid #4198D3; padding: 15px 15px 15px 15px; margin-right: 15px; background-color: #eeeeee; border-radius: 5px;">' . $paragraph[0] . '</div>';
        echo '</div><br>';
    }
    echo '<hr><br>';
}

?>
<?= Html::endPanel() ?>
