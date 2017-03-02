<?php
namespace developit\jcrop;
use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@developit/jcrop/assets';

    public $css = [
        'css/jcrop.css'
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'js/jcrop.js'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'developit\jcrop\JcropAsset',
        'developit\jcrop\SimpleAjaxUploaderAsset',
    ];
}