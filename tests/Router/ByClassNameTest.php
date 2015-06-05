<?php namespace ApishkaTest\EasyExtend\Router;

use Apishka\EasyExtend\Router\ByClassName;

/**
 * By class name test
 *
 * @runTestsInSeparateProcesses
 * @uses \PHPUnit_Framework_TestCase
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class ByClassNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get broker
     *
     * @access protected
     * @return void
     */

    protected function getRouter()
    {
        return new ByClassName();
    }

    /**
     * Test cached data
     *
     * @access public
     * @return void
     */

    public function testEmptyCachedData()
    {
        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
            ),
            $router->getData()
        );
    }

    /**
     * Test simple cache data
     *
     * @access public
     * @return void
     */

    public function testSimple()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test simple cache data
     *
     * @access public
     * @return void
     */

    public function testExtending()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');
        require_once('tests/Router/Fixtures/Tree/MichurinCherry.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\MichurinCherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test simple cache data
     *
     * @access public
     * @return void
     */

    public function testExtendingWithBranch()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');
        require_once('tests/Router/Fixtures/Tree/Mandarin.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
                ),
            ),
            $router->getData()
        );
    }
}
