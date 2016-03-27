<?php namespace Apishka\EasyExtend;

/**
 * Broker
 */

final class Broker extends RouterAbstract
{
    /**
     * Instance
     *
     *
     * @var mixed
     */

    private static $_instance = null;

    /**
     * Cache
     *
     * @var mixed
     */

    protected $_routers = array();

    /**
     * Apishka
     *
     *
     * @return RouterAbstract
     */

    public static function apishka()
    {
        return static::getInstance();
    }

    /**
     * Returns the *Singleton* instance of this class.
     *
     *
     * @return Broker
     */

    public static function getInstance()
    {
        if (self::$_instance === null)
            self::$_instance = new static();

        return self::$_instance;
    }

    /**
     * Clear instance
     */

    public static function clearInstance()
    {
        self::$_instance = null;
    }

    /**
     * Get router instance
     *
     * @param string $class
     *
     * @return RouterAbstract
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
     *
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        if ($reflector->isInstance($this))
            return false;

        if (!$this->hasClassInterface($reflector, 'Apishka\EasyExtend\RouterInterface'))
            return false;

        return true;
    }

    /**
     * Construct
     */

    protected function __construct()
    {
    }

    /**
     * Clone
     */

    private function __clone()
    {
    }

    /**
     * Wakeup
     */

    private function __wakeup()
    {
    }
}
