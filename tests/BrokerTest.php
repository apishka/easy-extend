<?php

namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Broker;

/**
 * Broker test
 *
 * @runTestsInSeparateProcesses
 */

class BrokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tear down
     */

    protected function tearDown()
    {
        Broker::clearInstance();
    }

    /**
     * Get broker
     */

    protected function getBroker()
    {
        return Broker::getInstance();
    }

    /**
     * Test cached data
     */

    public function testEmptyCachedData()
    {
        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
            ),
            $broker->getData()
        );
    }

    /**
     * Test simple cache data
     */

    public function testSimple()
    {
        require_once 'tests/Fixtures/RouterA.php';
        require_once 'tests/Fixtures/RouterB.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Fixtures\RouterA' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterA',
                ),
                'ApishkaTest\EasyExtend\Fixtures\RouterB' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterB',
                ),
            ),
            $broker->getData()
        );
    }

    /**
     * Test simple cache data
     */

    public function testExtending()
    {
        require_once 'tests/Fixtures/RouterA.php';
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Fixtures\RouterA' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterA',
                ),
                'ApishkaTest\EasyExtend\Fixtures\RouterB' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterB1',
                ),
            ),
            $broker->getData()
        );
    }

    /**
     * Test simple cache data
     */

    public function testExtendingWithBranch()
    {
        require_once 'tests/Fixtures/RouterA.php';
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';
        require_once 'tests/Fixtures/RouterB2.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Fixtures\RouterA' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterA',
                ),
                'ApishkaTest\EasyExtend\Fixtures\RouterB' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterB1',
                ),
                'ApishkaTest\EasyExtend\Fixtures\RouterB2' => array(
                    'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterB2',
                ),
            ),
            $broker->getData()
        );
    }

    /**
     * Test simple cache data
     *
     * @expectedException \LogicException
     * @expectedExceptionMessage Class 'ApishkaTest\\EasyExtend\\Fixtures\\RouterB3' has no direct relation with class 'ApishkaTest\\EasyExtend\\Fixtures\\RouterB1'
     */

    public function testExtendingTwice()
    {
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';
        require_once 'tests/Fixtures/RouterB3.php';

        $broker = $this->getBroker();
        $broker->cache();
    }

    /**
     * Test get router
     */

    public function testGetRouter()
    {
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertInstanceOf(
            'ApishkaTest\EasyExtend\Fixtures\RouterB',
            $broker->getRouter('ApishkaTest\EasyExtend\Fixtures\RouterB')
        );
    }

    /**
     * Test get item
     */

    public function testGetItem()
    {
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertInstanceOf(
            'ApishkaTest\EasyExtend\Fixtures\RouterB1',
            $broker->getItem('ApishkaTest\EasyExtend\Fixtures\RouterB')
        );
    }

    /**
     * Test get item data
     */

    public function testGetItemData()
    {
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
                'class' => 'ApishkaTest\EasyExtend\Fixtures\RouterB1',
            ),
            $broker->getItemData('ApishkaTest\EasyExtend\Fixtures\RouterB')
        );
    }

    /**
     * Test get items list
     */

    public function testGetItemsList()
    {
        require_once 'tests/Fixtures/RouterB.php';
        require_once 'tests/Fixtures/RouterB1.php';

        $broker = $this->getBroker();
        $broker->cache();

        $this->assertEquals(
            array(
                'ApishkaTest\EasyExtend\Fixtures\RouterB',
            ),
            $broker->getItemsList()
        );
    }
}
