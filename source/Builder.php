<?php namespace Apishka\EasyExtend;

use Composer\Script\Event;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Symfony\Component\Finder\Finder;
use Apishka\EasyExtend\Broker;

/**
 * Builder
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Builder
{
    /**
     * Event
     *
     * @type Event
     * @access private
     */

    private $_event = null;

    /**
     * Finders
     *
     * @type array
     * @access private
     */

    private $_finders = array();

    /**
     * Logger
     *
     * @type IOInterface
     * @access private
     */

    private $_logger = null;

    /**
     * Build
     *
     * @param Event $event
     * @access public
     * @return void
     */

    public function buildFromEvent(Event $event)
    {
        $this->setEvent($event);

        $configs = $this->getConfigFilesByComposer();
        $this->addFindersByConfigs($configs);

        // We have to initialize composer autoload
        require_once('vendor/autoload.php');

        $this->build();
    }

    /**
     * Build from cache
     *
     * @access public
     * @return void
     */

    public function buildFromCache()
    {
        $configs = Cacher::getInstance()->fetch($this->getConfigsCacheName());
        $this->addFindersByConfigs($configs);
        $this->build();
    }

    /**
     * Add finders by configs
     *
     * @param array $configs
     * @access protected
     * @return Builder this
     */

    protected function addFindersByConfigs(array $configs)
    {
        foreach ($configs as $package => $path)
        {
            $data = @include($path);

            if ($data && isset($data['easy-extend']))
            {
                $config = $data['easy-extend'];

                if ($config)
                {
                    if (isset($config['finder']))
                    {
                        $finder_callbacks = $config['finder'];

                        if (!is_array($finder_callbacks))
                            $finder_callbacks = array($finder_callbacks);

                        foreach ($finder_callbacks as $callback)
                        {
                            $finder = new Finder();
                            $finder = $callback($finder);

                            $this->addFinder($finder);
                        }
                    }

                    if (isset($config['bootstrap']))
                    {
                        $config['bootstrap']();
                    }
                }
            }
        }
    }

    /**
     * Build
     *
     * @access public
     * @return void
     */

    public function build()
    {
        $this->requireFiles();

        Broker::getInstance()->cache();

        foreach (Broker::getInstance()->getData() as $info)
        {
            $class = $info['class'];

            $router = new $class();
            $router->cache();
        }
    }

    /**
     * Add finder
     *
     * @param Finder $finder
     * @access public
     * @return RouterAbstract this
     */

    public function addFinder(Finder $finder)
    {
        $this->_finders[] = $finder;

        return $this;
    }

    /**
     * Require files
     *
     * @access protected
     * @return RouterAbstract this
     */

    protected function requireFiles()
    {
        foreach ($this->_finders as $finder)
        {
            foreach ($finder as $file)
            {
                require_once($file->getRealpath());
            }
        }

        return $this;
    }

    /**
     * Get config files by composer
     *
     * @access protected
     * @return Builder
     */

    protected function getConfigFilesByComposer()
    {
        $this->getLogger()->write('<info>Searching for config files</info>');

        $configs = array();
        if ($this->isDependantPackage($this->getEvent()->getComposer()->getPackage()))
        {
            $path = $this->getConfigPackagePath('./', $this->getEvent()->getComposer()->getPackage());

            if ($path)
                $configs[] = $path;
        }

        $packages = $this->getEvent()->getComposer()->getRepositoryManager()->getLocalRepository()->getPackages();
        foreach ($packages as $package)
        {
            if ($this->isDependantPackage($package, false))
            {
                $path = $this->getConfigPackagePath(
                    $this->getEvent()->getComposer()->getInstallationManager()->getInstallPath($package),
                    $package
                );

                if ($path)
                    $configs[] = $path;
            }
        }

        Cacher::getInstance()->save(
            $this->getConfigsCacheName(),
            $configs
        );

        return $configs;
    }

    /**
     * Get config package file path
     *
     * @param string $dir
     * @param PackageInterface $package
     * @access protected
     * @return null|string
     */

    protected function getConfigPackagePath($dir, $package)
    {
        $dir = preg_replace(
            '#^(' . preg_quote(getcwd() . DIRECTORY_SEPARATOR, '#') . ')#',
            '.' . DIRECTORY_SEPARATOR,
            $dir
        );

        $this->getLogger()->write(
            sprintf(
                '<info>Looking for ".apishka.php" file for %s</info>',
                $package->getPrettyName()
            )
        );

        $path = $this->getConfigPath($dir);
        if (file_exists($path))
        {
            $this->getLogger()->write(
                sprintf(
                    '<info>Found config file for %s</info>',
                    $package->getPrettyName()
                )
            );

            return $path;
        }

        return null;
    }

    /**
     * Get configs cache name
     *
     * @access protected
     * @return string
     */

    protected function getConfigsCacheName()
    {
        return 'configs';
    }

    /**
     * Get config path
     *
     * @param string $folder
     * @access protected
     * @return string
     */

    protected function getConfigPath($folder)
    {
        return rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.apishka.php';
    }

    /**
     * Returns true if the supplied package requires the Composer NPM bridge.
     *
     * @param PackageInterface $package The package to inspect.
     * @param boolean|null     $dev_mode True if the dev dependencies should also be inspected.
     * @access public
     * @return boolean True if the package requires the bridge.
     */

    public function isDependantPackage(PackageInterface $package, $dev_mode = null)
    {
        if ($package->getName() === 'apishka/easy-extend')
            return true;

        foreach ($package->getRequires() as $link)
        {
            if ($link->getTarget() === 'apishka/easy-extend')
                return true;
        }

        if ($dev_mode)
        {
            foreach ($package->getDevRequires() as $link)
            {
                if ($link->getTarget() === 'apishka/easy-extend')
                    return true;
            }
        }

        return false;
    }

    /**
     * Set event
     *
     * @param Event $event
     * @access protected
     * @return Builder
     */

    protected function setEvent(Event $event)
    {
        $this->_event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @access protected
     * @return Event
     */

    protected function getEvent()
    {
        return $this->_event;
    }

    /**
     * Set logger
     *
     * @param IOInterface $logger
     * @access public
     * @return Builder
     */

    public function setLogger(IOInterface $logger)
    {
        $this->_logger = $logger;

        return $this;
    }

    /**
     * Get logger
     *
     * @access public
     * @return IOInterface
     */

    public function getLogger()
    {
        if ($this->_logger === null)
        {
            if ($this->getEvent() !== null)
            {
                $this->_logger = $this->getEvent()->getIO();
            }
            else
            {
                $this->_logger = new NullIO();
            }
        }

        return $this->_logger;
    }
}
