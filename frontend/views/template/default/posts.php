<?php
echo yii\widgets\ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => 'post_item',
]);
