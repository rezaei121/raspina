<?php

namespace tests\codeception\frontend\unit;

/**
 * @inheritdoc
 */
class DbTestCase extends \yii\codeception\DbTestCase
{
    public $appConfig = '@tests/codeception/_config/frontend/unit.php';
}
