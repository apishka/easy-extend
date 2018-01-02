<?php declare(strict_types = 1);

namespace Apishka\EasyExtend;

/**
 * Broker
 */
final class Broker extends RouterAbstract
{
    /**
     * Instance
     *
     * @var Broker|null
     */
    private static $_instance;

    /**
     * Cache
     *
     * @var RouterAbstract[]
     */
    private $_routers = array();

    /**
     * @return Broker
     */
    public static function apishka(): self
    {
        return static::getInstance();
    }

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Broker
     */
    public static function getInstance(): self
    {
        if (self::$_instance === null)
            self::$_instance = new static();

        return self::$_instance;
    }

    /**
     * Clear instance
     */
    public static function clearInstance(): void
    {
        self::$_instance = null;
    }

    /**
     * Get router instance
     *
     * @param string $router
     *
     * @return RouterAbstract
     */
    public function getRouter($router): RouterAbstract
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
    protected function getCacheData(): array
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
    protected function isCorrectItem(\ReflectionClass $reflector): bool
    {
        if ($reflector->isInstance($this))
            return false;

        if (!$reflector->isSubclassOf(RouterAbstract::class))
            return false;

        return true;
    }

    /**
     * Construct
     */
    private function __construct()
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
