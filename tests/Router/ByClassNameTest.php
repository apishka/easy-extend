<?php

namespace ApishkaTest\EasyExtend\Router;

use Apishka\EasyExtend\Router\ByClassName;

/**
 * By class name test
 *
 * @runTestsInSeparateProcesses
 */
class ByClassNameTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Get broker
     */

    protected function getRouter()
    {
        return new ByClassName();
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
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
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
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';
        require_once 'tests/Router/Fixtures/Tree/MichurinCherry.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\MichurinCherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
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
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';
        require_once 'tests/Router/Fixtures/Tree/Mandarin.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Mandarin',
                    'prefixes'  => 'apishka',
                ),
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange' => array(
                    'class'     => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
                    'prefixes'  => 'apishka',
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
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertInstanceOf(
            'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
            $router->getItem('ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple')
        );
    }

    /**
     * Test get item data
     */

    public function testGetItemData()
    {
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'class'    => 'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                'prefixes' => 'apishka',
            ),
            $router->getItemData('ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple')
        );
    }

    /**
     * Test get items list
     */

    public function testGetItemsList()
    {
        require_once 'tests/Router/Fixtures/Tree/Apple.php';
        require_once 'tests/Router/Fixtures/Tree/Cherry.php';
        require_once 'tests/Router/Fixtures/Tree/Orange.php';

        $router = $this->getRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Apple',
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Cherry',
                'ApishkaTest\EasyExtend\Router\Fixtures\Tree\Orange',
            ),
            $router->getItemsList()
        );
    }
}
