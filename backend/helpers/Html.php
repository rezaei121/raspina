<?php
namespace backend\helpers;
class Html extends \yii\helpers\BaseHtml
{
    public static function beginPanel($title,$size = 12,$button = '')
    {
        return "<div class=\"col-md-{$size}\"><div class=\"panel panel-default\"><div class=\"panel-heading\">{$title} <span class=\"panel-button\">{$button}</span></div><div class=\"panel-body\">";
    }

    public static function endPanel()
    {
        return '</div></div></div>';
    }
}