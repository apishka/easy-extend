<?php namespace ApishkaTest\EasyExtend\Router;

use Apishka\EasyExtend\Router\ByClassName;
use Symfony\Component\Finder\Finder;

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

    /**
     * Test wihtout extending
     *
     * @access public
     * @return void
     */

    public function testWihtoutExtending()
    {
        $finder = new Finder();
        $finder
            ->files()
            ->name('*.php')
            ->in(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR . 'Tree')
        ;

        $router = $this->createRouter();
        $router->addFinder($finder);
        $router->cache();
    }
}
