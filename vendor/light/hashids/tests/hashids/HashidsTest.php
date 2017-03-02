<?php namespace light\hashids;

class HashidsTest extends \PHPUnit_Framework_TestCase
{
    public function testEncode()
    {
        $hashids = \Yii::createObject([
            'class' => 'light\hashids\Hashids'
        ]);

        $id = $hashids->encode(1, 2, 3);

        $this->assertEquals($hashids->decode($id), [1, 2, 3]);
    }
}
