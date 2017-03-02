<?php
namespace developit\jcrop;
use yii\web\AssetBundle;
class SimpleAjaxUploaderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/simple-ajax-uploader/';
    public $js = [
        'SimpleAjaxUploader.min.js'
    ];
}