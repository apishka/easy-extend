<?php declare(strict_types = 1);

namespace Apishka\EasyExtend;

use Apishka\EasyExtend\Cache\PhpFileCache;

/**
 * Cacher
 */
class Cacher
{
    /**
     * Instance
     *
     * @var self|null
     */
    private static $_instance;

    /**
     * Cache
     *
     * @var PhpFileCache
     */
    protected $_cache;

    /**
     * Cache dir
     *
     * @var string
     */
    protected $_cache_dir;

    /**
     * @return self
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
     * @param string $id
     * @param mixed  $value
     *
     * @return bool
     */
    public function set(string $id, $value): bool
    {
        return $this->getCache()->set($id, $value);
    }

    /**
     * @param string $id
     *
     * @return array
     */
    public function get(string $id): array
    {
        return $this->getCache()->get($id);
    }

    public function flush(): void
    {
        $this->getCache()->flush();
    }

    /**
     * Get cache dir
     *
     * return string
     */
    public function getCacheDir(): string
    {
        if ($this->_cache_dir === null)
            $this->_cache_dir = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');

        return $this->_cache_dir;
    }

    /**
     * Set cache dir
     *
     * @param string $dir
     *
     * @return Cacher this
     */
    public function setCacheDir($dir): self
    {
        $this->_cache_dir = $dir;

        return $this;
    }

    /**
     * Get cache
     *
     * @return PhpFileCache
     */
    protected function getCache(): PhpFileCache
    {
        if ($this->_cache === null)
            $this->_cache = new PhpFileCache($this->getCacheDir());

        return $this->_cache;
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
