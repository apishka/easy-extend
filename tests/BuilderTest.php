<?php

namespace ApishkaTest\EasyExtend;

use Apishka\EasyExtend\Builder;
use Apishka\EasyExtend\Cacher;
use Composer\Autoload\AutoloadGenerator;
use Composer\Composer;
use Composer\Config;
use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Plugin\PluginManager;
use Composer\Script\Event;

/**
 * Tests of easy extend builder
 *
 * @runTestsInSeparateProcesses
 */
class BuilderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Composer
     */
    protected $_composer;

    /**
     * Directory
     *
     * @var mixed
     */
    protected $_directory;

    /**
     * @var IOInterface
     */
    protected $_io;

    /**
     * Repository
     *
     * @var InstalledRepositoryInterface
     */
    protected $_repository;

    /**
     * Root package
     *
     * @var RootPackage
     */
    protected $_root_package;

    /**
     * Generage packages
     *
     * @return array
     */
    protected function generagePackages()
    {
        $result = array();

        foreach (range('a', 'b') as $i)
        {
            $name    = 'vendor' . $i . '/package' . $i;
            $package = new Package($name, '1.0.0', '1.0.0');
            $package->setRequires(
                array(
                    new Link($name, 'apishka/easy-extend'),
                )
            );

            $result[] = $package;
        }

        return $result;
    }

    /**
     * Set up
     */
    protected function setUp()
    {
        $this->_directory = __DIR__ . '/Fixtures/package';

        Cacher::getInstance()
            ->setCacheDir(sys_get_temp_dir() . '/apishka-cacher')
        ;

        $this->root_package = new RootPackage('apishka/testpackage', '1.0.0', '1.0.0');
        $this->root_package->setRequires(
            array(
                new Link('apishka/testpackage', 'vendorX/packageX'),
                new Link('apishka/testpackage', 'vendorY/packageY'),
                new Link('apishka/testpackage', 'apishka/easy-extend'),
            )
        );

        $dm = $this->getMockBuilder('Composer\Downloader\DownloadManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->_repository = $this->createMock('Composer\Repository\InstalledRepositoryInterface');

        $this->_repository->expects($this->any())
            ->method('getPackages')
            ->will(
                $this->returnValue(
                    $this->generagePackages()
                )
            )
        ;

        $rm = $this->getMockBuilder('Composer\Repository\RepositoryManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $rm->expects($this->any())
            ->method('getLocalRepository')
            ->will($this->returnValue($this->_repository))
        ;

        $im = $this->createMock('Composer\Installer\InstallationManager');
        $im->expects($this->any())
            ->method('getInstallPath')
            ->will($this->returnCallback(function ($package) {
                return $this->_directory . '/vendor/' . $package->getPrettyName();
            }))
        ;

        $this->_io = $this->createMock('Composer\IO\IOInterface');

        $dispatcher = $this->getMockBuilder('Composer\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->_composer = new Composer();
        $config          = new Config();
        $this->_composer->setConfig($config);
        $this->_composer->setDownloadManager($dm);
        $this->_composer->setRepositoryManager($rm);
        $this->_composer->setInstallationManager($im);
        $this->_composer->setAutoloadGenerator(
            new AutoloadGenerator($dispatcher)
        );

        $this->_composer->setPackage($this->root_package);

        $this->_composer->setPluginManager(
            new PluginManager($this->_io, $this->_composer)
        );
    }

    /**
     * Tear down
     */
    protected function tearDown()
    {
        Cacher::getInstance()->flush();

        Cacher::clearInstance();

        $this->_composer = null;
        $this->_io       = null;
    }

    /**
     * Test root package path
     */
    public function testRootPackagePath()
    {
        $builder = new Builder();

        $this->assertEquals(
            './',
            $builder->getRootPackagePath()
        );
    }

    /**
     * Test set root package path
     */
    public function testSetRootPackagePath()
    {
        $builder = (new Builder())
            ->setRootPackagePath($this->_directory)
        ;

        $this->assertEquals(
            $this->_directory,
            $builder->getRootPackagePath()
        );
    }

    /**
     * Test by keys routing
     */
    public function testByKeysCachedData()
    {
        $event = new Event(
            'post-update-cmd',
            $this->_composer,
            $this->_io
        );

        $builder = new Builder();
        $builder
            ->setRootPackagePath($this->_directory)
            ->buildFromEvent($event)
        ;

        $router = new \VendorA\PackageA\ByKeyRouter();
        $router->cache();

        $this->assertEquals(
            array(
                'classa' => array(
                    'class'     => 'ApishkaTest\TestPackage\ClassAtoC',
                ),
                'classb' => array(
                    'class'     => 'VendorB\PackageB\ClassB',
                ),
            ),
            $router->getData()
        );
    }

    /**
     * Test by class name routing
     */
    public function testByClassNameCachedData()
    {
        require_once 'source/Router/ByClassName.php';

        $event = new Event(
            'post-update-cmd',
            $this->_composer,
            $this->_io
        );

        $builder = new Builder();
        $builder
            ->setRootPackagePath($this->_directory)
            ->buildFromEvent($event)
        ;

        $router = new \Apishka\EasyExtend\Router\ByClassName();
        $router->cache();

        $this->assertEquals(
            array(
                'VendorA\PackageA\ClassA' => array(
                    'class'     => 'ApishkaTest\TestPackage\ClassAtoC',
                    'prefixes'  => 'apishka',
                ),
                'VendorB\PackageB\ClassB' => array(
                    'class'     => 'VendorB\PackageB\ClassB',
                    'prefixes'  => 'apishka|testishka',
                ),
            ),
            $router->getData()
        );
    }
}
