<?php

namespace tests\codeception\common\unit;

/**
 * @inheritdoc
 */
class DbTestCase extends \yii\codeception\DbTestCase
{
    public $appConfig = '@tests/codeception/_config/common/unit.php';
}
