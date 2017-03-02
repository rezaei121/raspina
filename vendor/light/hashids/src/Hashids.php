<?php namespace light\hashids;

use yii\base\Object;
use Hashids\Hashids as BaseHashids;
/**
 * This is a wrapper for Hashids
 * @package light\hashids
 * @version 1.0.2
 * @author lichunqiang<light-li@hotmail.com>
 */
class Hashids extends Object
{
    /**
     * The salt
     * @var string
     */
    public $salt;
    /**
     * The min hash length
     * @var integer
     */
    public $minHashLength = 0;
    /**
     * The alphabet for hashids
     * @var string
     */
    public $alphabet;
    /**
     * The instance of the Hashids
     * @var Hashids\Hashids
     */
    private $_hashids;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->_hashids = new BaseHashids($this->salt, $this->minHashLength, $this->alphabet);
    }
    /**
     * @inheritdoc
     */
    public function __call($name, $params)
    {
        if (method_exists($this->_hashids, $name)) {
            return call_user_func_array([$this->_hashids, $name], $params);
        }
        return parent::__call($name, $params);
    }
}
