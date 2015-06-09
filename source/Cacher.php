<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\Cache\PhpFileCache;

/**
 * Cacher
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Cacher
{
    /**
     * Instance
     *
     * @static
     *
     * @var mixed
     */

    private static $_instance = null;

    /**
     * Cache
     *
     * @var mixed
     */

    protected $_cache = null;

    /**
     * Cache dir
     *
     * @var string
     */

    protected $_cache_dir = null;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @static
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
     */

    public static function clearInstance()
    {
        self::$_instance = null;
    }

    /**
     * Call
     *
     * @param string $name
     * @param array  $arguments
     */

    public function __call($name, $arguments)
    {
        return $this->getCache()->$name(...$arguments);
    }

    /**
     * Get cache dir
     *
     * return string
     */

    public function getCacheDir()
    {
        if ($this->_cache_dir === null)
            $this->_cache_dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');

        return $this->_cache_dir;
    }

    /**
     * Set cache dir
     *
     * @param string $dir
     * @return Cacher this
     */

    public function setCacheDir($dir)
    {
        $this->_cache_dir = $dir;

        return $this;
    }

    /**
     * Get cache
     *
     * @return PhpFileCache
     */

    protected function getCache()
    {
        if ($this->_cache === null)
            $this->_cache = new PhpFileCache($this->getCacheDir());

        return $this->_cache;
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
