<?php namespace Apishka\EasyExtend;

use Doctrine\Common\Cache\PhpFileCache;

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

    protected $_cache = null;

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
     * Call
     *
     * @param string $name
     * @param array $arguments
     * @access public
     * @return void
     */

    public function __call($name, $arguments)
    {
        return $this->getCache()->$name(...$arguments);
    }

    /**
     * Get cache dir
     *
     * @access public
     * @return void
     */

    public function getCacheDir()
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');
    }

    /**
     * Get cache
     *
     * @access protected
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
