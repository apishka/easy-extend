<?php namespace ApishkaTest\EasyExtend;

use Composer\Composer;
use Composer\Config;
use Composer\Installer\PluginInstaller;
use Composer\Package\CompletePackage;
use Composer\Package\Loader\JsonLoader;
use Composer\Package\Loader\ArrayLoader;
use Composer\Plugin\PluginManager;
use Composer\Autoload\AutoloadGenerator;
use Composer\TestCase;
use Composer\Util\Filesystem;
use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Script\Event;
use Apishka\EasyExtend\Builder;
use Apishka\EasyExtend\Cacher;

/**
 * Tests of easy extend builder
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Autoload generator
     *
     * @type mixed
     * @access protected
     */

    protected $autoloadGenerator;

    /**
     * @var Composer
     */

    protected $_composer;

    /**
     * Directory
     *
     * @type mixed
     * @access protected
     */

    protected $directory;

    /**
     * @var IOInterface
     */

    protected $_io;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */

    protected $package;

    /**
     * Repository
     *
     * @type mixed
     * @access protected
     */

    protected $repository;

    protected function generagePackages()
    {
        $result = array();

        foreach (range('a', 'b') as $i)
        {
            $name = 'vendor' . $i . '/package' . $i;
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
        Cacher::getInstance()
            ->setCacheDir(sys_get_temp_dir() . '/apishka-cacher')
        ;

        $this->rootPackage = new RootPackage('apishka/testpackage', '1.0.0', '1.0.0');
        $this->rootPackage->setRequires(
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

        $this->repository = $this->getMock('Composer\Repository\InstalledRepositoryInterface');

        $this->repository->expects($this->any())
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
            ->will($this->returnValue($this->repository))
        ;

        $im = $this->getMock('Composer\Installer\InstallationManager');
        $im->expects($this->any())
            ->method('getInstallPath')
            ->will($this->returnCallback(function ($package) {
                return __DIR__ . '/Fixtures/package/vendor/' . $package->getPrettyName();
            }))
        ;

        $this->_io = $this->getMock('Composer\IO\IOInterface');

        $dispatcher = $this->getMockBuilder('Composer\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->autoloadGenerator = new AutoloadGenerator($dispatcher);

        $this->_composer = new Composer();
        $config = new Config();
        $this->_composer->setConfig($config);
        $this->_composer->setDownloadManager($dm);
        $this->_composer->setRepositoryManager($rm);
        $this->_composer->setInstallationManager($im);
        $this->_composer->setAutoloadGenerator($this->autoloadGenerator);
        $this->_composer->setPackage($this->rootPackage);

        $this->pm = new PluginManager($this->_io, $this->_composer);
        $this->_composer->setPluginManager($this->pm);
    }

    /**
     * Tear down
     */

    protected function tearDown()
    {
        //$filesystem = new Filesystem();
        //$filesystem->removeDirectory(Cacher::getInstance()->getCacheDir());

        Cacher::clearInstance();

        $this->_composer = null;
        $this->_io = null;
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
        $path = __DIR__ . '/Fixtures/package/';

        $builder = (new Builder())
            ->setRootPackagePath($path)
        ;

        $this->assertEquals(
            $path,
            $builder->getRootPackagePath()
        );
    }

    /**
     * Test simple
     */

    public function testSimple()
    {
        //$event = new Event(
        //    'post-update-cmd',
        //    $this->_composer,
        //    $this->_io
        //);
        //
        //$builder = new Builder();
        //$builder
        //    ->setRootPackagePath(__DIR__ . '/Fixtures/package/')
        //    ->buildFromEvent($event)
        //;
    }
}
