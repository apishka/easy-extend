<?php namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Broker;

/**
 * Broker test
 *
 * @runTestsInSeparateProcesses
 * @uses \PHPUnit_Framework_TestCase
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class BrokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get broker
     *
     * @access protected
     * @return void
     */

    protected function getBroker()
    {
        return new Broker();
    }

    /**
     * Test cached data
     *
     * @access public
     * @return void
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
     *
     * @access public
     * @return void
     */

    public function testSimpleCacheData()
    {
        require_once('tests/Fixtures/RouterA.php');
        require_once('tests/Fixtures/RouterB.php');

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
}
