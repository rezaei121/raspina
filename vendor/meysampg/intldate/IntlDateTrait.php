<?php

namespace meysampg\intldate;

use IntlDateFormatter;
use Exception;
use IntlCalendar;

trait IntlDateTrait
{
    private $timezone = 'Asia/Tehran';
    private $fromLocale;
    private $toLocale;
    private $fromCalendar;
    private $toCalendar;

    private $intlDateFormatter;
    private $intlCalendar;

    static $CAL_PERSIAN = 'persian';
    static $CAL_JAPANESE = 'japanese';
    static $CAL_BUDDHIST = 'buddhist';
    static $CAL_CHINESE = 'chinese';
    static $CAL_INDIAN = 'indian';
    static $CAL_ISLAMIC = 'islamic';
    static $CAL_HEBREW = 'hebrew';
    static $CAL_COPTIC = 'coptic';
    static $CAL_ETHIOPIC = 'ethiopic';
    static $CAL_GREGORIAN = '';

    public function asDateTime($pattern = 'yyyy/MM/dd, HH:mm:ss')
    {
        $this->setFinalPattern($this->parsePattern($pattern));

        return $this->getIntlDateFormatter()->format($this->getIntlCalendar());
    }

    public function asTimestamp()
    {
        return $this->getIntlCalendar()->toDateTime()->format('U');
    }

    public function fromTimestamp($timestamp)
    {
        $dateArray = getdate($timestamp);
        unset($dateArray[0]);

        $this->from($dateArray);

        return $this;
    }

    public function from($datetime = [], $locale = 'en_US', $calendar = null)
    {
        $datetime = $this->parseDateTime($datetime);
        $calendar = $calendar ?: self::$CAL_GREGORIAN;

        $this->setIntlCalendar()
             ->setFromCalendar($calendar)->setFromLocale($locale)
             ->setOriginCalendar($this->getFromLocaleAndCalendar())
             ->setOriginDate($datetime);

        return $this;
    }

    public function to($locale = 'en_US', $calendar = null)
    {  
        $calendar = $calendar !== null ? $calendar : self::$CAL_PERSIAN;

        $this->setIntlDateFormatter()
             ->setToCalendar($calendar)->setToLocale($locale)
             ->setFinalCalendar($this->getToLocaleAndCalendar());

        if ($calendar == self::$CAL_GREGORIAN) {
            $this->setFinalCalendarType(IntlDateFormatter::GREGORIAN);
        } else {
            $this->setFinalCalendarType(IntlDateFormatter::TRADITIONAL);
        }

        return $this;
    }

    public function fromPersian($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_PERSIAN);

        return $this;
    }

    public function toPersian($locale = 'fa')
    {
        $this->to($locale, self::$CAL_PERSIAN);

        return $this;
    }

    public function fromJapanese($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_JAPANESE);

        return $this;
    }

    public function toJapanese($locale = 'jp')
    {
        $this->to($locale, self::$CAL_JAPANESE);

        return $this;
    }

    public function fromBuddhist($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_BUDDHIST);

        return $this;
    }

    public function toBuddhist($locale = 'th')
    {
        $this->to($locale, self::$CAL_BUDDHIST);

        return $this;
    }

    public function fromChinese($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_CHINESE);

        return $this;
    }

    public function toChinese($locale = 'ch')
    {
        $this->to($locale, self::$CAL_CHINESE);

        return $this;
    }

    public function fromIndian($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_INDIAN);

        return $this;
    }

    public function toIndian($locale = 'hi')
    {
        $this->to($locale, self::$CAL_INDIAN);

        return $this;
    }

    public function fromIslamic($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_ISLAMIC);

        return $this;
    }

    public function toIslamic($locale = 'ar')
    {
        $this->to($locale, self::$CAL_ISLAMIC);

        return $this;
    }

    public function fromHebrew($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_HEBREW);

        return $this;
    }

    public function toHebrew($locale = 'he')
    {
        $this->to($locale, self::$CAL_HEBREW);

        return $this;
    }

    public function fromCoptic($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_COPTIC);

        return $this;
    }

    public function toCoptic($locale = 'en_US')
    {
        $this->to($locale, self::$CAL_COPTIC);

        return $this;
    }

    public function fromEthiopic($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_ETHIOPIC);

        return $this;
    }

    public function toEthiopic($locale = 'am')
    {
        $this->to($locale, self::$CAL_ETHIOPIC);

        return $this;
    }

    public function fromGregorian($datetime, $locale = 'en_US')
    {
        $this->from($datetime, $locale, self::$CAL_GREGORIAN);

        return $this;
    }

    public function toGregorian($locale = 'en_US')
    {
        $this->to($locale, self::$CAL_GREGORIAN);

        return $this;
    }

    public function setOriginDate($datetimeArray)
    {
        $this->getIntlCalendar()->set($datetimeArray[0], $datetimeArray[1], $datetimeArray[2], $datetimeArray[3], $datetimeArray[4], $datetimeArray[5]);

        return $this;
    }

    public function getFinalDate()
    {
        return $this->getIntlDateFormatter()->formatter($this->getIntlCalendar());
    }

    public function setFromLocale($locale)
    {
        $this->fromLocale = trim($locale);

        return $this;
    }

    public function getFromLocale()
    {
        return $this->fromLocale;
    }

    public function setFromCalendar($calendar)
    {
        $this->fromCalendar = '@calendar=' . trim($calendar);

        return $this;
    }

    public function getFromCalendar()
    {
        return $this->fromCalendar;
    }

    public function setToLocale($locale)
    {
        $this->toLocale = trim($locale);

        return $this;
    }

    public function getToLocale()
    {
        return $this->toLocale;
    }

    public function setToCalendar($calendar)
    {
        $this->toCalendar = '@calendar=' . trim($calendar);

        return $this;
    }

    public function getToCalendar()
    {
        return $this->toCalendar;
    }

    public function getFromLocaleAndCalendar()
    {
        return $this->getFromLocale() . $this->getFromCalendar();
    }

    public function getToLocaleAndCalendar()
    {
        return $this->getToLocale() . $this->getToCalendar();
    }

    public function setOriginTimeZone($timezone)
    {
        $this->getIntlCalendar()->setTimeZone($timezone);

        return $this;
    }

    public function getOriginTimeZone()
    {
        return $this->getIntlCalendar()->getTimeZone();
    }

    public function setFinalTimeZone($timezone)
    {
        $this->setIntlDateFormatter(
            $this->getToLocaleAndCalendar(),
            $this->getFinalDateType(),
            $this->getFinalTimeType(),
            $timezone,
            $this->getFinalCalendarType(),
            $this->getFinalPattern()
        );

        return $this;
    }

    public function getFinalTimeZone()
    {
        return $this->getIntlDateFormatter()->getTimeZone();
    }

    public function setOriginCalendar($locale)
    {
        $this->setIntlCalendar(
            $this->getOriginTimeZone(),
            $locale
        );

        return $this;
    }

    public function getOriginCalendar()
    {
        return $this->getIntlCalendar()->getLocale();
    }

    public function setFinalCalendar($locale)
    {
        $this->setIntlDateFormatter(
            $locale,
            $this->getFinalDateType(),
            $this->getFinalTimeType(),
            $this->getFinalTimeZone(),
            $this->getFinalCalendarType(),
            $this->getFinalPattern(),
            true
        );

        return $this;
    }

    public function getFinalCalendar()
    {
        return $this->getIntlDateFormatter()->getLocale();
    }

    public function setFinalDateType($datetype)
    {
        $this->setIntlDateFormatter(
            $this->getToLocaleAndCalendar(),
            $datetype,
            $this->getFinalTimeType(),
            $this->getFinalTimeZone(),
            $this->getFinalCalendarType(),
            $this->getFinalPattern(),
            true
        );

        return $this;
    }

    public function getFinalDateType()
    {
        $this->getIntlDateFormatter()->getDateType();
    }

    public function setFinalTimeType($timetype)
    {
        $this->setIntlDateFormatter(
            $this->getToLocaleAndCalendar(),
            $this->getFinalDateType(),
            $timetype,
            $this->getFinalTimeZone(),
            $this->getFinalCalendarType(),
            $this->getFinalPattern(),
            true
        );

        return $this;
    }

    public function getFinalTimeType()
    {
        return $this->getIntlDateFormatter()->getTimeType();
    }

    public function setFinalCalendarType($calendarType)
    {
        $this->setIntlDateFormatter(
            $this->getToLocaleAndCalendar(),
            $this->getFinalDateType(),
            $this->getFinalTimeType(),
            $this->getFinalTimeZone(),
            $calendarType,
            $this->getFinalPattern(),
            true
        );

        return $this;
    }

    public function getFinalCalendarType()
    {
        return $this->getIntlDateFormatter()->getCalendar();
    }

    public function setFinalPattern($pattern)
    {
        $this->getIntlDateFormatter()->setPattern($pattern);

        return $this;
    }

    public function getFinalPattern()
    {
        return $this->getIntlDateFormatter()->getPattern();
    }

    // [TODO]
    public function parsePattern($pattern)
    {
        /**
         * Implement a function to parse both ICU patterns and php date
         * function patterns and return a pattern that is compatible on
         * ICU format. The php pattern must start with php keyword, for
         * example `php:Y-F-d, H:i:s` is a php pattern.
         */
        return $pattern;
    }

    // [TODO]
    public function guessDateTime($timestring)
    {
        /**
         * Implement a function to convert '2016/01/22 11:43:24' to an array
         * like
         * [
         *      0 => 2016, // Year
         *      1 => 0, // Month. IntlCalendar use 0 for first month and so on.
         *      2 => 22, // Day
         *      3 => 11, // Hour
         *      4 => 43, // Minute
         *      5 => 24, // Seconds
         * ]
         */
    }

    /**
     * Parse DateTime information array to be in correct format.
     * 
     * @param array $datetimeArray array contains information of DateTime in 
     * `year, month, day, hour, minute, day` order. This parameter can be a
     * either associative or non-associative array. For the former, keys must 
     * be compitiable with http://php.net/manual/en/function.getdate.php. For
     * missing pieces of information, a corresponded part from 1970/1/Jan., 00:00:00
     * will be replaced.
     * 
     * @return An `IntlDateFormatter` compitiable array.
     */
    private function parseDateTime($datetimeArray)
    {
        $finalDatetimeArray = [];

        if (!is_array($datetimeArray)) {
            throw new Exception("DateTime information must be an array.");
        }

        $finalDatetimeArray[0] = isset($datetimeArray[0]) ? (int)$datetimeArray[0] : (isset($datetimeArray['year']) ? (int)$datetimeArray['year'] : 1970);
        $finalDatetimeArray[1] = isset($datetimeArray[1]) ? (int)$datetimeArray[1] - 1 : (isset($datetimeArray['mon']) ? (int)$datetimeArray['mon'] - 1 : 0);
        $finalDatetimeArray[2] = isset($datetimeArray[2]) ? (int)$datetimeArray[2] : (isset($datetimeArray['mday']) ? (int)$datetimeArray['mday'] : 1);
        $finalDatetimeArray[3] = isset($datetimeArray[3]) ? (int)$datetimeArray[3] : (isset($datetimeArray['hours']) ? (int)$datetimeArray['hours'] : 0);
        $finalDatetimeArray[4] = isset($datetimeArray[4]) ? (int)$datetimeArray[4] : (isset($datetimeArray['minutes']) ? (int)$datetimeArray['minutes'] : 0);
        $finalDatetimeArray[5] = isset($datetimeArray[5]) ? (int)$datetimeArray[5] : (isset($datetimeArray['seconds']) ? (int)$datetimeArray['seconds'] : 0);

        return $finalDatetimeArray;
    }

    public function setIntlDateFormatter(
            $locale = "en_US",
            $datetype = IntlDateFormatter::FULL,
            $timetype = IntlDateFormatter::FULL,
            $timezone = 'UTC',
            $calendar = IntlDateFormatter::GREGORIAN,
            $pattern = 'yyyy/MM/dd HH:mm:ss'
        )
    {
        $this->intlDateFormatter = new IntlDateFormatter(
            $locale, // string $locale
            $datetype, // int $datetype
            $timetype, // int $timetype
            $timezone, // mixed $timezone
            $calendar, // mixed $calendar
            $pattern // string $pattern
        );

        return $this;
    }

    public function getIntlDateFormatter()
    {
        return $this->intlDateFormatter;
    }

    public function setIntlCalendar(
            $timezone = 'Asia/Tehran',
            $locale = 'fa_IR@calendar=persian'
        )
    {

        $this->intlCalendar = IntlCalendar::createInstance(
            $timezone,
            $locale
        );

        return $this;
    }

    public function getIntlCalendar()
    {
        return $this->intlCalendar;
    }
}
