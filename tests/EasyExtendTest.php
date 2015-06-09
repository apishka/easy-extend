<?php namespace ApishkaTest\EasyExtend;

use Composer\Composer;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Repository\RepositoryManager;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

/**
 * Tests of easy extend plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EasyExtendTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EasyExtend
     */

    protected $plugin;

    /**
     * @var Composer
     */

    protected $composer;

    /**
     * @var IOInterface
     */

    protected $io;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */

    protected $package;

    /**
     * Set up
     */

    protected function setUp()
    {
        $io         = $this->getMock('Composer\IO\IOInterface');
        $composer   = $this->getMock('Composer\Composer');

        $config = $this->getMock('Composer\Config');
        $config->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function ($key) {
                switch ($key) {
                    case 'cache-repo-dir':
                        return sys_get_temp_dir() . '/composer-test-repo-cache';
                }

                return;
            }))
        ;

        $this->package = $this->getMock('Composer\Package\RootPackageInterface');
        $this->package->expects($this->any())
            ->method('getRequires')
            ->will($this->returnValue(array()))
        ;

        $this->package->expects($this->any())
            ->method('getDevRequires')
            ->will($this->returnValue(array()))
        ;

        $rm = new RepositoryManager($io, $config);
        $im = new InstallationManager();

        $composer = $this->getMock('Composer\Composer');
        $composer->expects($this->any())
            ->method('getRepositoryManager')
            ->will($this->returnValue($rm))
        ;

        $composer->expects($this->any())
            ->method('getPackage')
            ->will($this->returnValue($this->package))
        ;

        $composer->expects($this->any())
            ->method('getConfig')
            ->will($this->returnValue($config))
        ;

        $composer->expects($this->any())
            ->method('getInstallationManager')
            ->will($this->returnValue($im))
        ;

        $this->plugin = new \Apishka\EasyExtend\EasyExtend();
        $this->composer = $composer;
        $this->io = $io;
    }

    /**
     * Tear down
     */

    protected function tearDown()
    {
        $this->plugin = null;
        $this->composer = null;
        $this->io = null;
    }

    /**
     * Test activate
     */

    public function testActivate()
    {
        $this->assertNull($this->plugin->activate($this->composer, $this->io));
    }

    /**
     * Test builder creation
     */

    public function testBuilderCreation()
    {
        $this
            ->assertInstanceOf('Apishka\EasyExtend\Builder', $this->plugin->getBuilder())
        ;

        $builder = $this->getMock('Apishka\EasyExtend\Builder');

        $this->plugin->setBuilder($builder);

        $this
            ->assertInstanceOf(get_class($builder), $this->plugin->getBuilder())
        ;
    }

    /**
     * Test subscribe events
     */

    public function testSubscribeEvents()
    {
        $this->assertEquals(
            array(
                ScriptEvents::POST_INSTALL_CMD  => 'onPostInstallCmd',
                ScriptEvents::POST_UPDATE_CMD   => 'onPostInstallCmd',
            ),
            $this->plugin->getSubscribedEvents()
        );

        $event = new Event(
            'post-update-cmd',
            $this->composer,
            $this->io
        );

        $builder = $this->getMock('Apishka\EasyExtend\Builder');

        $builder->expects($this->once())
            ->method('buildFromEvent')
            ->with($this->equalTo($event))
        ;

        $this->plugin
            ->setBuilder($builder)
            ->onPostInstallCmd($event)
        ;
    }
}
