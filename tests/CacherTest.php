<?php

namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Cacher;

/**
 * Cacher test
 */

class CacherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tear down
     */

    protected function tearDown()
    {
        Cacher::clearInstance();
    }

    /**
     * Create cacher
     *
     * @return Cacher
     */

    protected function getCacher()
    {
        return Cacher::getInstance();
    }

    /**
     * Test cache path
     */

    public function testCacheDir()
    {
        $cacher = $this->getCacher();

        $this->assertEquals(
            realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache'),
            $cacher->getCacheDir()
        );
    }

    /**
     * Test set cache dir
     */

    public function testSetCacheDir()
    {
        $path = sys_get_temp_dir() . '/apishka-cacher';

        $cacher = $this->getCacher()
            ->setCacheDir($path)
        ;

        $this->assertEquals(
            $path,
            $cacher->getCacheDir()
        );
    }
}
