yii2 captcha
============

![screenshot](http://www.developit.ir/tmp/yii2-captcha.jpg)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist developit/yii2-captcha "~1.0"
```

or add

```
"developit/yii2-captcha": "~1.0"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply modify your controler, add or change methode `actions()`:

```php
    public function actions()
    {
        $this->layout = $this->setting['layout'];
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'developit\captcha\CaptchaAction',
                'type' => 'numbers', // 'numbers', 'letters' or 'default' (contains numbers & letters)
                'minLength' => 4,
                'maxLength' => 4,
            ],
        ];
    }
```

In view
```php
use developit\captcha\Captcha;
<?=
$form->field($model, 'verifyCode')->widget(Captcha::className())
?>

