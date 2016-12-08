<rss version="2.0">
    <channel>
        <title><?= $this->title ?></title>
        <link><?= $this->params['url'] ?> </link>
        <description><?= $this->params['url'] ?></description>
        <language>fa-ir</language>
        <copyright>Copyright (C) 2009 mywebsite.com</copyright>
        <?php foreach ((array)$posts as $p): ?>
        <item>
            <title><?= $p['title'] ?></title>
            <link><?= $this->params['url'] ?>post/view/<?= $p['id'] ?>/<?= $p['title'] ?>.html</link>
            <pubDate><?= date('l, F d, Y', $p['create_time']) ?></pubDate>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>