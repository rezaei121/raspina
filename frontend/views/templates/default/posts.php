<?php
use frontend\components\helpers\Raspina;

$request = Yii::$app->request->get();
if(isset($request['category']))
{
	Raspina::title($request['title']);
}

echo yii\widgets\ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => 'post_item',
]);
