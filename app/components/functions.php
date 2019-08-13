<?php

use yii\web\Request;

/**
 * @param $data
 */
function vd($data)
{
    var_dump($data);
    exit();
}

/**
 * @param $data
 */
function pr($data)
{
    print_r($data);
    exit();
}

/**
 * @return mixed|null
 * @throws \yii\base\InvalidConfigException
 */
function getAppName()
{
    $baseUrl = str_replace(['/app', '\\'], null, (new Request)->getBaseUrl());
    $re = "{$baseUrl}\/([a-z]+)/";
    $str = (new Request)->getUrl();
    preg_match($re, $str, $matches);
    return (isset($matches[1]) ? $matches[1] : null);
}
