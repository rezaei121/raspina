<?php
namespace developit\pdate;

use Yii;

class DateTime
{
    public function pdate($timestamp = null,$dateFormat = 'HH:mm - yyyy/MM/dd')
    {
        if($timestamp === null)
        {
            $timestamp = time();
        }

        $fmt = new \IntlDateFormatter(
            'fa_IR@calendar=persian',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL,
            'Iran',
            \IntlDateFormatter::TRADITIONAL,
            $dateFormat
        );
        return $this->fa_to_en_numbers($fmt->format($timestamp));
    }

    public function jalali_to_gregorian($j_y, $j_m, $j_d, $g_h = 0, $g_m = 0)
    {
        static $g_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        static $j_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        $jy = $j_y - 979;
        $jm = $j_m - 1;
        $j_day_no = (365 * $jy + $this->div($jy, 33) * 8 + $this->div($jy % 33 + 3, 4));

        for($i = 0; $i < $jm; ++ $i)
        {
            $j_day_no += $j_days_in_month[$i];
        }

        $j_day_no += $j_d - 1;
        $g_day_no= $j_day_no + 79;
        $gy = (1600 + 400 * $this->div($g_day_no, 146097)); # 146097 = (365 * 400 + 400 / 4 - 400 / 100 + 400 / 400)
        $g_day_no= $g_day_no % 146097;
        $leap = 1;

        if($g_day_no >= 36525) # 36525 = (365 * 100 + 100 / 4)
        {
            $g_day_no --;
            $gy += (100 * $this->div($g_day_no, 36524)); # 36524 = (365 * 100 + 100 / 4 - 100 / 100)
            $g_day_no= $g_day_no % 36524;
            if($g_day_no >= 365)
            {
                $g_day_no ++;
            }
            else
            {
                $leap = 0;
            }
        }

        $gy += (4 * $this->div($g_day_no, 1461)); # 1461 = (365 * 4 + 4 / 4)
        $g_day_no %= 1461;

        if($g_day_no >= 366)
        {
            $leap = 0;
            $g_day_no --;
            $gy += $this->div($g_day_no, 365);
            $g_day_no = ($g_day_no % 365);
        }

        for($i = 0; $g_day_no >= ($g_days_in_month[$i] + ($i == 1 && $leap)); $i ++)
        {
            $g_day_no -= ($g_days_in_month[$i] + ($i == 1 && $leap));
        }

        $array = array($gy, $i + 1, $g_day_no + 1);
        $gregorianTime = implode('/',$array) . ' ' . $g_h . ':' . $g_m;
        $gregorianTimestamp = strtotime($gregorianTime);
        return $gregorianTimestamp;
    }

    private function div($a, $b)
    {
        return (int)($a / $b);
    }

    private function fa_to_en_numbers($numbers)
    {
        $fa_numbers = array('۱','۲','۳','۴','۵','۶','۷','۸','۹','۰');
        $en_numbers = array('1','2','3','4','5','6','7','8','9','0');
        return str_replace($fa_numbers,$en_numbers,$numbers);
    }
}
