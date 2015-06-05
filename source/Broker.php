<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\RouterAbstract;

/**
 * Broker
 *
 * @uses RouterAbstract
 * @final
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

final class Broker extends RouterAbstract
{
    /**
     * Instance
     *
     * @static
     * @type mixed
     * @access private
     */

    static private $_instance = null;

    /**
     * Cache
     *
     * @type mixed
     * @access protected
     */

    protected $_routers = null;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @static
     * @access public
     * @return void
     */

    public static function getInstance()
    {
        if (self::$_instance === null)
            self::$_instance = new static();

        return self::$_instance;
    }

    /**
     * Clear instance
     *
     * @static
     * @access public
     * @return void
     */

    public static function clearInstance()
    {
        self::$_instance = null;
    }

    /**
     * Get router instance
     *
     * @param string $class
     * @access public
     * @return void
     */

    public function getRouter($router)
    {
        if (!array_key_exists($router, $this->_routers))
            $this->_routers[$router] = $this->getItem($router);

        return $this->_routers[$router];
    }

    /**
     * Get cache data
     *
     * @access protected
     * @return array
     */

    protected function getCacheData()
    {
        $data = parent::getCacheData();

        ksort($data);

        return $data;
    }

    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     * @access protected
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        if (!parent::isCorrectItem($reflector))
            return false;

        if ($reflector->isInstance($this))
            return false;

        if (!$this->hasClassInterface($reflector, 'Apishka\EasyExtend\RouterInterface'))
            return false;

        return true;
    }

    /**
     * Construct
     *
     * @access protected
     * @return void
     */

    protected function __construct()
    {
    }

    /**
     * Clone
     *
     * @access private
     * @return void
     */

    private function __clone()
    {
    }

    /**
     * Wakeup
     *
     * @access private
     * @return void
     */

    private function __wakeup()
    {
    }
}
