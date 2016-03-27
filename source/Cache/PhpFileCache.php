<?php namespace Apishka\EasyExtend\Cache;

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

    public function __construct($cache_dir)
    {
        $this->setCacheDir($cache_dir);
    }

    /**
     * Set
     *
     * @param string $id
     * @param mixed  $value
     *
     * @return PhpFileCache
     */

    public function set($id, $value)
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

            @unlink($tmpFile);
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

    protected function getFileName($id)
    {
        return rtrim($this->getCacheDir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $id . '.php';
    }

    /**
     * Returns cache data
     *
     * @param string $id
     *
     * @return mixed
     */

    public function get($id)
    {
        $filename = $this->getFileName($id);

        // note: error suppression is still faster than `file_exists`, `is_file` and `is_readable`
        $value = @include $filename;

        return $value['data'];
    }

    /**
     * Flush
     */

    public function flush()
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
            @unlink($file->getRealpath());
        }
    }

    /**
     * Set cache dir
     *
     * @param string $cache_dir
     *
     * @return PhpFileCache this
     */

    protected function setCacheDir($cache_dir)
    {
        $this->_cache_dir = $cache_dir;

        return $this;
    }

    /**
     * Get cache dir
     *
     * @return string
     */

    protected function getCacheDir()
    {
        return $this->_cache_dir;
    }
}
