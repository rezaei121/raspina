<?php
namespace dashboard\components\widgets;

use Yii;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldClass = 'dashboard\components\widgets\ActiveField';
}