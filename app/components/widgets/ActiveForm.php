<?php
namespace app\components\widgets;

use Yii;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'app\components\widgets\ActiveField';
}