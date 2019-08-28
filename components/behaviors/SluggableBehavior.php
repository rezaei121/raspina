<?php
namespace app\components\behaviors;

class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    protected function generateSlug($slugParts)
    {
        $replacement = '-';
        return preg_replace('/[:!@#$%^&*()+|><"\'?؟\{\}\[\]=\s—–-]+/u', $replacement, implode($replacement, $slugParts));
    }
}