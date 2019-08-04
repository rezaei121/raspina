<?php

namespace app\components\web;


use Yii;

class View extends \yii\web\View
{
    /**
     * @inheritdoc
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        $script = '
        <script src="'.\Yii::getAlias('@web/app/web/js/ua-parser.min.js').'"></script>
        <script>
        var parser = new UAParser();
        var result = parser.getResult();
        var userInfo = {
            browser: result.browser.name
        }
        var params = "browser=" + result.browser.name + "&";
        params += "browser_version=" + parseInt(result.browser.version) + "&";
        params += "device=" + result.device.name + "&";
        params += "device_model=" + result.device.model + "&";
        params += "os=" + result.os.name + "&";
        params += "os_version=" + result.os.version + "&";
        params += "referrer=" + document.referrer;
        var http = new XMLHttpRequest();
        var url = " ' .Yii::$app->params['url']. 'statistics/visitor/add";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send(params);
        </script>
        ';
        return parent::renderBodyEndHtml($ajaxMode) . $script;
    }
}
