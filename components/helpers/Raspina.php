<?php
namespace app\components\helpers;
use app\modules\link\models\Link;
use app\modules\post\models\Category;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Raspina
{
    public static function title($title = null)
    {
        $title = Yii::t('app', $title);
        if($title !== null)
        {
            Yii::$app->view->title .= ' - ' . $title;
        }
        return Yii::$app->view->title;
    }

    public static function request($method = 'get', $name = null)
    {
        if($method == 'get')
        {
            return Yii::$app->request->get($name);
        }
        return Yii::$app->request->post($name);
    }

    public static function t($message, $params = [])
    {
        return Yii::t('app', $message, $params);
    }

    public static function dump($var)
    {
        var_dump($var);
    }

    public static function a($text, $url)
    {
        return Html::a($text, $url);
    }

    public static function date($date)
    {
        return Yii::$app->date->asDatetime($date);
    }

    public static function description()
    {
        return Yii::$app->params['siteDescription'];
    }

    public static function keywords()
    {
        return Yii::$app->params['keywords'];
    }

    public static function csrfMetaTags()
    {
        return Yii::$app->params['csrfMetaTags'];
    }

    public static function charset()
    {
        return Yii::$app->params['charset'];
    }

    public static function templateUrl()
    {
        return Yii::$app->params['templateUrl'];
    }

    public static function templateDir()
    {
        return Yii::$app->params['templateDir'] . '/';
    }

    public static function siteDescription()
    {
        return Yii::$app->params['siteDescription'];
    }

    public static function subject()
    {
        return Yii::$app->params['subject'];
    }

    public static function url()
    {
        return Yii::$app->params['url'];
    }

    public static function isAvatar()
    {
        $avatarPath = Yii::getAlias('@user_avatar') . DIRECTORY_SEPARATOR . Yii::$app->hashids->encode(Yii::$app->user->id) . '.jpg';
        return file_exists($avatarPath);
    }

    public static function avatarImage()
    {
        return Yii::$app->view->params['url'] . 'common/files/avatar/' . Yii::$app->hashids->encode(Yii::$app->user->id) . '.jpg';
    }

    public static function authorName()
    {
        return Yii::$app->view->params['about']['name'];
    }

    public static function aboutText()
    {
        return Yii::$app->view->params['about']['short_text'];
    }

    public static function siteModel()
    {
        return Yii::$app->params['index'];
    }

    public static function categories($withUrl = true)
    {
        $result = Category::getAll();
        if($withUrl)
        {
            foreach ($result as $key => $value)
            {
                $result[$key]['url'] = Url::to(['/post/default/index', 'category' => $result[$key]['id'],'title' => $result[$key]['slug']]);
            }
        }
        return $result;
    }

    public static function postCategories($model)
    {
        $categories = [];
        foreach ((array)$model['postCategories'] as $postCategory)
        {
            $categories[] = [
                'id' => $postCategory->category['id'],
                'title' => $postCategory->category['title'],
                'slug' => $postCategory->category['slug'],
                'url' => Url::to(['/post/default/index', 'category' => $postCategory->category['id'],'title' => $postCategory->category['slug']])
            ];
        }
        return $categories;
    }

    public static function links()
    {
        return Link::getAll();
    }

    public static function param($id)
    {
        return Yii::$app->view->params[$id];
    }

    public static function lang()
    {
        return Yii::$app->language;
    }

    public static function direction()
    {
        return Yii::$app->params['direction'];
    }

    public static function counter()
    {
        $script = '
        <script src="'.\Yii::getAlias('@web/web/js/ua-parser.min.js').'"></script>
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
        params += "referrer=" + document.referrer + "&";
        params += "module=" + "'.Yii::$app->controller->module->id.'" + "&";
        params += "action=" + "'.Yii::$app->controller->action->id.'" + "&";
        params += "id=" + "'.Yii::$app->request->get("id").'" + "&";
        params += "_csrf=" + yii.getCsrfToken();
        var http = new XMLHttpRequest();
        var url = " ' .Yii::$app->params['url']. 'statistics/visitor/add";
        http.open("POST", url, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send(params);
        </script>
        ';
        return $script;
    }
}
