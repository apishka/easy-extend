<?php namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Cacher;

/**
 * Cacher test
 *
 * @uses \PHPUnit_Framework_TestCase
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class CacherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tear down
     *
     * @access protected
     * @return void
     */

    protected function tearDown()
    {
        Cacher::clearInstance();
    }

    /**
     * Create cacher
     *
     * @access protected
     * @return Cacher
     */

    protected function getCacher()
    {
        return Cacher::getInstance();
    }

    /**
     * Test cache path
     *
     * @access public
     * @return void
     */

    public function testCacheDir()
    {
        $cacher = $this->getCacher();

        $this->assertEquals(
            realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache'),
            $cacher->getCacheDir()
        );
    }
}
