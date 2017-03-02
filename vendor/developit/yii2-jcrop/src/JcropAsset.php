<?php
namespace developit\jcrop;
use yii\web\AssetBundle;
class JcropAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/jcrop/';
    public $js = [
        'js/jquery.Jcrop.min.js'
    ];
    public $css = [
        'css/jquery.Jcrop.min.css'
    ];
}