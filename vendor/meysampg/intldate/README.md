Intl. Date
==========
PHP Library for Converting Date to Multiple Calendars

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer require --prefer-dist meysampg/intldate "*"
```

or add

```json
"meysampg/intldate": "*"
```

to the require section of your `composer.json` file.

Also easily you can [Download](https://github.com/meysampg/intldate/archive/master.zip) and use it.

Usage
-----

Once the library is installed, simply use it in your php file:

```php
use meysampg\intldate\IntlDateTrait;
```
and use it on your desired class:

```php
<?php

namespace foo\bar;

use meysampg\intldate\IntlDateTrait;

class Bar
{
  use IntlDateTrait;
  // Some codes are here!
 
  echo $this->fromGregorian([2017, 9, 7, 12, 23, 45])->toPersian('en')->asDateTime();
}
```

Anathomy
--------

`IntlDateTrait` has a simple logic for naming methods: "A date starts from *origin* and ends to *final*. So all methods (setters and getters) that are related to incoming date are named by `setOriginXXXX` and `getOriginXXXX` (which `XXXX` shows a feature of time, like *timezone* or *locale*) and all methods that are corresponded to outgoing date are regarded as `setFinalXXXX` and `getFinalXXXX`. A list of available methods can be find in bottom of this document.

Conversion
----------
At first I must note that incoming date must be an array in this form:

```php
[
    year, // 2016
    month, // 2
    day, // 23
    hour, // 12
    minute, // 23
    second // 4
]
```
Currently, the library **CAN'T** parse a string as time (See ToDo section), so before converting a date, you **MUST** parse it on a acceptable array (It can be done with `preg_match` or each tools that you know). Now you can easily use
`IntlDateTrait::from($datetimeArray, $locale, $calendar)` for importing an incoming date and `IntlDateTrait::to($locale, $calendar)` for converting it to another system. We disccuesed about `$datetimeArray` in the first of this section, it's our date for converting on a accepted format. `$locale` is the regional information of a language. For example for The *English* it's `en`, for *Farsi* it's `fa`, for *Spanish* it's `es` and so on. You can find a complete list of them at [this link](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes). And finally calendar is your desired date system. This library use the `Intl*` family of `php` and so you can use all supported calendar in `ICU` project. Now this calendars are supported:
 - persian
 - gregorian
 - japanese
 - buddhist
 - chinese
 - indian
 - islamic
 - hebrew
 - coptic
 - ethiopic

It's better to use their handler in code instead of using direct name. These handlers are:

```php
// Use them in `self::$CAL_CALENDAR, for example `$calendar = self::$CAL_HEBREW`.
$CAL_PERSIAN
$CAL_JAPANESE
$CAL_BUDDHIST
$CAL_CHINESE
$CAL_INDIAN
$CAL_ISLAMIC
$CAL_HEBREW
$CAL_COPTIC
$CAL_ETHIOPIC
$CAL_GREGORIAN
```

ShortHands
----------
There are some shorthands for converting dates in a painless way (Yeah! With all of my proud, I'm a **Lazy** man :D). This shorthands are formatted as `fromYyyy()` for incoming date function and `toZzzz()` for outgoing date function such that, `Yyyy` and `Zzzz` are the name of calendars. For incoming function, the signature is `fromYyyy($datetimeArray, $locale = 'en_US', $timezone = 'UTC)` and for outgoing is `toZzzz($locale = 'fa', $timezone = 'UTC')`. Use `$locale` in incoming function if you have non-latin digits and use it on outgoing function, if you wanna show the converted date by latin digits (Based on region of calendar, `$locales` are defined, for example the default locate of `Persian` calendar for outgoing function is `fa`). Also with changing `$timezone` in both `fromYyyy` and `ToZzzz` functions, you can convert a datetime from one to another. Shorthands are listed in table.

|   Incoming    |   Outgoing    |
|---------------|---------------|
|fromPersian    |   toPersian   |
|fromJapanese   |toJapanese     |
|fromBuddhist   |toBuddhist     |
|fromChinese    |toChinese      |
|fromIndian     |toIndian       |
|fromIslamic    |toIslamic      |
|fromHebrew     |toHebrew       |
|fromCoptic     |toCoptic       |
|fromEthiopic   |toEthiopic     |
|fromGregorian  |toGregorian    |

Showing Date
------------
There are two functions for showing converted dates. The first is `asDateTime` and the last one is `asTimestamp`.

Signature of `asDateTime` is `asDateTime($pattern = 'yyyy/MM/dd, HH:mm:ss')`. This function accepts an `ICU`-acceptable format. You can find more info from [this link](http://www.icu-project.org/apiref/icu4c/classSimpleDateFormat.html#details). Also it's good idea for implementing a function that parse traditional php `date`-acceptable format (See ToDo section).

`asTimestamp` function return the unix epoch, positive integer for time after that and negative integer for before that.

Examples
--------
There are some examples for using `IntlDateTrait`. I think they are necessary and sufficent.

```php
$this->fromTimestamp(1504770825)->toPersian('en')->asDateTime();
// '1396/06/16, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toPersian('en')->asDateTime();
// '1396/06/16, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toPersian()->asDateTime();
// '۱۳۹۶/۰۶/۱۶, ۰۷:۵۳:۴۵'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toJapanese()->asDateTime();
// '0029/09/07, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toIslamic()->asDateTime();
// '١٤٣٨/١٢/١٧, ٠٧:٥٣:٤٥'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toBuddhist()->asDateTime();
// '2560/09/07, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toChinese()->asDateTime();
// '0034/07/17, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toIndian()->asDateTime();
// '1939/06/16, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toHebrew()->asDateTime();
// 'תשע״ז/י״ב/ט״ז, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toCoptic()->asDateTime();
// '1733/13/02, 07:53:45'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->toEthiopic()->asDateTime();
// '2009/13/02, 07:53:45'

$this->fromPersian([1396, 6, 16, 12, 23, 45])->toIslamic()->asDateTime();
// '١٤٣٨/١٢/١٧, ٠٧:٥٣:٤٥'

$this->fromPersian([1396, 6, 16, 12, 23, 45])->toGregorian()->asDateTime();
// '2017/09/07, 07:53:45'

$this->fromPersian([1396, 6, 16, 12, 23, 45])->toGregorian()->setFinalTimeZone('Asia/Tehran')->asDateTime();
// '2017/09/07, 12:23:45'

$this->fromPersian([1396, 6, 16, 12, 23, 45])->toGregorian()->setFinalTimeZone('Asia/Tehran')->asDateTime('yyyy');
// '2017'

$this->fromGregorian([2017, 9, 7, 12, 23, 45])->asTimestamp();
// '1504770825'

$this->fromPersian([1396, 6, 16, 12, 23, 45])->asTimestamp();
// '1504770825'
```

IntlDateTrait API
-----------------
There are some methods that help to control more on converting process. I just list them in this section. I think thier name complain their usages, If it's not, please write document for them :D.

|Setters                         |Gettes                    |
|--------------------------------|--------------------------|
|`setOriginDate($datetimeArray)` | `getFinalDate()`         |
|`setFromLocale($locale)`        |`getFromLocale()`         |
|`setFromCalendar($calendar)`    |`getFromCalendar()`       |
|`setToLocale($locale)`          |`getToLocale()`           |
|`setToCalendar($calendar)`      |`getToCalendar()`         |
|`getFromLocaleAndCalendar()`    |`getToLocaleAndCalendar()`|
|`setOriginTimeZone($timezone)`  |`getOriginTimeZone()`     |
|`setFinalTimeZone($timezone)`   |`getFinalTimeZone()`      |
|`setOriginCalendar($locale)`    |`getOriginCalendar()`     |
|`setFinalCalendar($locale)`     |`getFinalCalendar()`      |
|`setFinalDateType($datetype)`   |`getFinalDateType()`      |
|`setFinalTimeType($timetype)`   |`getFinalTimeType()`      |
|`setFinalCalendarType($calendarType)`|`getFinalCalendarType()`|
|`setFinalPattern($pattern)`     |`getFinalPattern()`       |
|`setIntlDateFormatter($locale = "en_US", $datetype = IntlDateFormatter::FULL, $timetype = IntlDateFormatter::FULL, $timezone = 'UTC', $calendar = IntlDateFormatter::GREGORIAN, $pattern = 'yyyy/MM/dd HH:mm:ss')`|`getIntlDateFormatter()`|
|`setIntlCalendar($timezone = 'Asia/Tehran', $locale = 'fa_IR@calendar=persian')`|`getIntlCalendar()`|

ToDo
----
 - Implement `parsePattern($pattern)` method.

 ```php
/**
 * Implement a function to parse both ICU patterns and php date
 * function patterns and return a pattern that is compatible on
 * ICU format. The php pattern must start with php keyword, for
 * example `php:Y-F-d, H:i:s` is a php pattern.
 */
 ```

 - Implement `guessDateTime($timestring)` method.

 ```php
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
 ```

 - ~~Write tests!~~
 
 Contribute
 ----------
 Just fork this repository, do your modification or addition and send a pull request!
