Yii2 Hashids
------------
[![Build Status](https://img.shields.io/travis/lichunqiang/hashids.svg?style=flat-square)](http://travis-ci.org/lichunqiang/hashids)
[![version](https://img.shields.io/packagist/v/light/hashids.svg?style=flat-square)](https://packagist.org/packages/light/hashids)
[![Download](https://img.shields.io/packagist/dd/light/hashids.svg?style=flat-square)](https://packagist.org/packages/light/hashids)
[![Issues](https://img.shields.io/github/issues/lichunqiang/hashids.svg?style=flat-square)](https://github.com/lichunqiang/hashids/issues)


## Installation

Install this package via [Composer](https://getcomposer.org/):

```
$ composer require light/hashids=*
```

## Usage

### configurate is as a component

In your `main.php` or `web.php` (dependences your yii2 project constructor):

```
[
	'hahsids' => [
		'class' => 'light\hashids\Hashids',
		//'salt' => 'your salt',
		//'minHashLenght' => 5,
		//'alphabet' => 'abcdefghigk'
	]
]
```

Also using this like this:

```
$hashids = Yii::createObject([
	'class' => 'light\hashids\Hashids'
]);

$id = $hashids->encode(1, 2, 3);
$numbers = $hashids->decode($id);
var_dump($id, $numbers);
```

## Test

```
$ phpunit
```

## Lisence

![MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)
