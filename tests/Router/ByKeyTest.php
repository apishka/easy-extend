<?php namespace ApishkaTest\EasyExtend\Router;

use ApishkaTest\EasyExtend\Router\Fixtures\ByKeyRouter;

/**
 * By key test
 *
 * @runTestsInSeparateProcesses
 */

class ByKeyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get broker
     */

    protected function getRouter()
    {
        return new ByKeyRouter();
    }

    /**
     * Test cached data
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
                'apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                ),
                'orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test simple cache data
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
                'apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\MichurinCherry',
                ),
                'orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test simple cache data
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
                'apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                ),
                'cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                ),
                'mandarin' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin',
                ),
                'orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test get item
     */

    public function testGetItem()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertInstanceOf(
            'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
            $router->getItem('apple')
        );
    }

    /**
     * Test get item data
     */

    public function testGetItemData()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'class'    => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
            ),
            $router->getItemData('apple')
        );
    }

    /**
     * Test get items list
     */

    public function testGetItemsList()
    {
        require_once('tests/Router/Fixtures/Tree/Apple.php');
        require_once('tests/Router/Fixtures/Tree/Cherry.php');
        require_once('tests/Router/Fixtures/Tree/Orange.php');

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'apple',
                'cherry',
                'orange',
            ),
            $router->getItemsList()
        );
    }
}
