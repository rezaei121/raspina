yii2 intl persian date
============

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist developit/yii2-pdate "~1.0"
```

or add

```
"developit/yii2-pdate": "~1.0"
```

to the require section of your `composer.json` file.


Usage
-----
In view
```php
use developit\pdate\Date;
<?= Date::widget(); // 00:30 - 1395/07/14 ?>
<?= Date::widget(['value' => 1475594367]); // 18:49 - 1395/07/13 ?>
<?= Date::widget(['value' => time(), 'format' => 'yyyy/MM/dd']); // 1395/07/14?>

