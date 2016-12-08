<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\Query;

class setting extends Component
{
    public function pageSize()
    {
        return $this->getValue('page_size');
    }

    public function getSult()
    {
        return $this->getValue('sult');
    }

    public function getValue($columnName)
    {
        $query = new Query;
        return $query->select($columnName)->from('{{%setting}}')->limit(1)->scalar();
    }

    public function get()
    {
        $query = new Query;
        $setting = $query->select('*')->from('{{%setting}}')->limit(1)->one();
        $setting['templateDir'] = '..' . DIRECTORY_SEPARATOR . Yii::getAlias('@template') . DIRECTORY_SEPARATOR . $setting['template'] . DIRECTORY_SEPARATOR;
        $setting['templateUrl'] = $setting['url'] . Yii::getAlias('@templateUrl') . '/' .$setting['template'] . '/';
        $setting['layout'] = $setting['templateDir'] . DIRECTORY_SEPARATOR . 'main.php';
        return $setting;
    }
}
