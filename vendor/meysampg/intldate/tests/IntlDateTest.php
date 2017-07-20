<?php

class IntlDateTest extends \PHPUnit\Framework\TestCase
{
    // mocked object contains intldate trait
    protected $intldate;

    public function testItShouldGetAnTimestampAndReturnTrueGregorianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $expected = '2017/07/03, 04:45:57';
        $actual = $intldate->fromTimestamp($now)->toGregorian()->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimestampAndReturnTruePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $expected = '1396/04/12, 04:45:57';
        $actual = $intldate->fromTimestamp($now)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedTimestampAndReturnTruePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499073357; // Monday, July 3, 2017 9:15:57 AM
        $tz = 'Asia/Tehran';
        $expected = '1396/04/12, 04:45:57';
        $actual = $intldate->fromTimestamp($now, $tz)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimestampAndReturnTruePersianTimezonedDateTime()
    {
        $intldate = $this->intldate;

        $now = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $tz = 'Asia/Tehran';
        $expected = '1396/04/12, 09:15:57';
        $actual = $intldate->fromTimestamp($now)->toPersian('en', $tz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnGregorianDateTimeAndReturnTrueTimestamp()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 04, 45, 57];
        $expected = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $actual = $intldate->fromGregorian($now)->asTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnPersianDateTimeAndReturnTrueTimestamp()
    {
        $intldate = $this->intldate;

        $now = [1396, 04, 12, 04, 45, 57];
        $expected = 1499057157; // Monday, July 3, 2017 4:45:57 AM
        $actual = $intldate->fromPersian($now)->asTimestamp();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnGregorianDateTimeAndReturnATimezonedPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 04, 45, 57];
        $expected = '1396/04/12, 09:15:57';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now)->toPersian('en', $tz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnAPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 9, 15, 57];
        $expected = '1396/04/12, 04:45:57';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now, 'en', $tz)->toPersian('en')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnATimezonedPersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 7, 15, 57];
        $expected = '1396/04/12, 04:45:57';
        $fromTz = 'Asia/Tehran';
        $toTz = 'Europe/Amsterdam';
        $actual = $intldate->fromGregorian($now, 'en', $fromTz)->toPersian('en', $toTz)->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    public function testItShouldGetAnTimezonedGregorianDateTimeAndReturnALocalePersianDateTime()
    {
        $intldate = $this->intldate;

        $now = [2017, 07, 03, 9, 15, 57];
        $expected = '۱۳۹۶/۰۴/۱۲, ۰۴:۴۵:۵۷';
        $tz = 'Asia/Tehran';
        $actual = $intldate->fromGregorian($now, 'en', $tz)->toPersian('fa')->asDateTime();

        $this->assertEquals($expected, $actual);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->intldate = $this->getMockForTrait('meysampg\intldate\IntlDateTrait');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->intldate = null;
    }
}

