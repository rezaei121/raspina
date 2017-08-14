<?php
namespace common\components\date;

class Formatter extends \yii\i18n\Formatter
{
    public function asDate($value, $format = null)
    {
        return $this->_convertNumbers(parent::asDate($value, $format));
    }

    public function asDatetime($value, $format = null)
    {
        return $this->_convertNumbers(parent::asDatetime($value, $format));
    }

    public function asTime($value, $format = null)
    {
        return $this->_convertNumbers(parent::asTime($value, $format));
    }

    private function _convertNumbers($date)
    {
        $fa_numbers = array('۱','۲','۳','۴','۵','۶','۷','۸','۹','۰');
        $en_numbers = array('1','2','3','4','5','6','7','8','9','0');
        return str_replace($fa_numbers,$en_numbers,$date);
    }
}