<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Cache;

use Symfony\Component\Finder\Finder;

/**
 * Php file cache
 */
class PhpFileCache
{
    /**
     * Cache dir
     *
     * @var string
     */
    protected $_cache_dir = null;

    /**
     * Construct
     *
     * @param string $cache_dir
     */
    public function __construct(string $cache_dir)
    {
        $this->setCacheDir($cache_dir);
    }

    /**
     * Set
     *
     * @param string $id
     * @param mixed  $value
     *
     * @return bool
     */
    public function set(string $id, $value): bool
    {
        $filename = $this->getFileName($id);
        $filepath = pathinfo($filename, PATHINFO_DIRNAME);

        if (!is_dir($filepath) && !@mkdir($filepath, 0777, true))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'The directory "%s" does not exist and could not be created',
                    $filepath
                )
            );
        }

        if (!is_writable($filepath))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'The directory "%s" is not writable',
                    $filepath
                )
            );
        }

        $tmp_file = tempnam($filepath, 'swap');

        $content = sprintf(
            '<?php return %s;',
            var_export(
                array(
                    'data'  => $value,
                ),
                true
            )
        );

        if (file_put_contents($tmp_file, $content) !== false)
        {
            if (@rename($tmp_file, $filename))
            {
                @chmod($filename, 0666 & ~umask());

                return true;
            }

            @unlink($tmp_file);
        }

        return false;
    }

    /**
     * Get file name
     *
     * @param string $id
     *
     * @return string
     */
    protected function getFileName(string $id): string
    {
        return rtrim($this->getCacheDir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $id . '.php';
    }

    /**
     * Returns cache data
     *
     * @param string $id
     *
     * @return array
     */
    public function get($id): array
    {
        $filename = $this->getFileName($id);

        // note: error suppression is still faster than `file_exists`, `is_file` and `is_readable`
        $value = @include $filename;

        return $value['data'];
    }

    /**
     * Flush
     */
    public function flush(): void
    {
        if (!is_dir($this->getCacheDir()))
            return;

        $finder = (new Finder())
            ->files()
            ->name('*.php')
            ->in($this->getCacheDir())
        ;

        foreach ($finder as $file)
        {
            /** @var $file \Symfony\Component\Finder\SplFileInfo */
            @unlink($file->getRealPath());
        }
    }

    /**
     * Set cache dir
     *
     * @param string $cache_dir
     *
     * @return PhpFileCache this
     */
    protected function setCacheDir(string $cache_dir): self
    {
        $this->_cache_dir = $cache_dir;

        return $this;
    }

    /**
     * Get cache dir
     *
     * @return string
     */
    protected function getCacheDir(): string
    {
        return $this->_cache_dir;
    }
}
