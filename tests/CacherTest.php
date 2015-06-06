<?php namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Cacher;

/**
 * Cacher test
 *
 * @uses \PHPUnit_Framework_TestCase
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class CacherTest extends \PHPUnit_Framework_TestCase
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
}
