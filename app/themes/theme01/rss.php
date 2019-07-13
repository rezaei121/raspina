<rss version="2.0">
    <channel>
        <title><?= $this->title ?></title>
        <link><?= Yii::$app->params['url'] ?> </link>
        <description><?= Yii::$app->params['url'] ?></description>
        <language><?= Yii::$app->params['lang'] ?></language>
        <copyright>Copyright (C) 2009 mywebsite.com</copyright>
        <?php foreach ((array)$posts as $p): ?>
        <item>
            <title><?= $p['title'] ?></title>
            <link><?= Yii::$app->params['url'] ?>post/view/<?= $p['id'] ?>/<?= $p['title'] ?>.html</link>
            <pubDate><?= $p['created_at'] ?></pubDate>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>