Jalali Bootstrap DatePicker Widget for Yii2
====================================

Renders a [Jalali Bootstrap DatePicker plugin](http://babakhani.github.io/PersianWebToolkit/persiandate).

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require mrlco/yii2-jalali-datepicker:~0.1.0
```
or add

```json
"mrlco/yii2-jalali-datepicker" : "~0.1.0"
```

to the require section of your application's `composer.json` file.

Usage
-----

### DatePicker

This widget renders a Bootstrap Persian DatePicker input control. Best suitable for model with date string attribute.

Example of use with a form
There are two ways of using it, with an ActiveForm instance or as a widget setting up its model and attribute.

```php
<?php
use mrlco\datepicker\Datepicker;
?>
```
```php
<?php
// as a widget
?>
```
```php
<?= Datepicker::widget([
    'model' => $model,
    'attribute' => 'date',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'format' => 'YYYY/MM/DD'
        ]
]);?>
```
```php
<?php 
// with an ActiveForm instance 
?>
<?= $form->field($model, 'date')->widget(
    Datepicker::className(), [
        'inline' => true,
        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
        'clientOptions' => [
            'format' => 'YYYY/MM/DD'
        ]
]);?>
```
Example of use without a model

```php
<?php
use mrlco\datepicker\Datepicker;
?>
<?= Datepicker::widget([
    'name' => 'Test',
    'value' => '1394/03/23',
    'template' => '{addon}{input}',
        'clientOptions' => [
            'format' => 'YYYY/MM/DD'
        ]
]);?>
```


Credits
-------

- [Mehran Barzandeh](https://github.com/mehrna)

License
-------

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.
)
