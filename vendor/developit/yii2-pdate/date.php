<?php
namespace developit\pdate;

use Yii;
use yii\base\Widget;

class Date extends Widget
{
    public $format = 'HH:mm - yyyy/MM/dd';
    public $value;


    public function init()
    {
        parent::init();
        if(empty($this->value))
        {
            $this->value = time();
        }
    }

    public function run()
    {
        return $this->_pdate($this->value,$this->format);
    }

    private function _pdate($timestamp,$dateFormat = '')
    {
        if(empty($dateFormat))
        {
            // $dateFormat = $setting;
            if(defined('DATE_FROMAT'))
            {
                $dateFormat = DATE_FROMAT;
            }
            else
            {
                $dateFormat = 'HH:mm - yyyy/MM/dd';
            }
        }


        if(empty($timestamp))
        {
            return FALSE;
        }

        $fmt = new \IntlDateFormatter(
                'fa_IR@calendar=persian',
                \IntlDateFormatter::FULL,
                \IntlDateFormatter::FULL,
                'Iran',
                \IntlDateFormatter::TRADITIONAL,
                $dateFormat
            );
        return $this->_changeNumbers($fmt->format($timestamp));
    }

    private function _changeNumbers($numbers)
    {
        $fa_numbers = array('۱','۲','۳','۴','۵','۶','۷','۸','۹','۰');
        $en_numbers = array('1','2','3','4','5','6','7','8','9','0');
        return str_replace($fa_numbers,$en_numbers,$numbers);
    }
}
