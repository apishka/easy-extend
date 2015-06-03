<?php namespace ApishkaTest\EasyExtend\Router;

use Apishka\EasyExtend\Router\ByClassName;

/**
 * By class name test
 *
 * @uses \PHPUnit_Framework_TestCase
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class ByClassNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create router
     *
     * @access protected
     * @return ByClassName
     */

    protected function createRouter()
    {
        return new ByClassName();
    }

    /**
     * Test cache name
     *
     * @access public
     * @return void
     */

    public function testCacheName()
    {
        $router = $this->createRouter();

        $this->assertEquals(
            'Apishka_EasyExtend_Router_ByClassName',
            $router->getCacheName()
        );
    }
}
