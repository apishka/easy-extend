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
                'Apishka\EasyExtend\Router\ByClassName' => array(
                    'class' => 'Apishka\EasyExtend\Router\ByClassName',
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
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
                'Apishka\EasyExtend\Router\ByClassName' => array(
                    'class' => 'Apishka\EasyExtend\Router\ByClassName',
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
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\MichurinCherry',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
                'Apishka\EasyExtend\Router\ByClassName' => array(
                    'class' => 'Apishka\EasyExtend\Router\ByClassName',
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
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array (
                    'class' => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
                'Apishka\EasyExtend\Router\ByClassName' => array(
                    'class' => 'Apishka\EasyExtend\Router\ByClassName',
                ),
            ),
            $router->getData()
        );
    }
}
