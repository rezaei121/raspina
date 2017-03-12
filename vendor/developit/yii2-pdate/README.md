yii2 intl persian date
============

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist developit/yii2-pdate "~2.0"
```

or add

```
"developit/yii2-pdate": "~2.0"
```

to the require section of your `composer.json` file.


Usage
-----
add to component:
```php
'date' => [
	'class' => 'developit\pdate\DateTime',
],
```
And use:
```php
Yii::$app->date->pdate(time(), 'HH:mm - yyyy/MM/dd')
```

