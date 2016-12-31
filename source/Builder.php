<?php

namespace Apishka\EasyExtend;

use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Script\Event;
use Symfony\Component\Finder\Finder;

/**
 * Builder
 */

class Builder
{
    /**
     * Event
     *
     * @var Event
     */

    private $_event = null;

    /**
     * Finders
     *
     * @var array
     */

    private $_finders = array();

    /**
     * Logger
     *
     * @var IOInterface
     */

    private $_logger = null;

    /**
     * Rootpath
     *
     * @var string
     */

    private $_root_package_path = null;

    /**
     * Build
     *
     * @param Event $event
     */

    public function buildFromEvent(Event $event)
    {
        $this->setEvent($event);

        $configs = $this->getConfigFilesByComposer();
        $this->addFindersByConfigs($configs);

        // We have to initialize composer autoload
        require_once 'vendor/autoload.php';

        $this->build();
    }

    /**
     * Build from cache
     */

    public function buildFromCache()
    {
        $this->addFindersByConfigs(
            $this->getConfigFilesFromCache()
        );

        $this->build();
    }

    /**
     * Get config files from cache
     *
     * @return array
     */

    public function getConfigFilesFromCache()
    {
        return Cacher::getInstance()->get($this->getConfigsCacheName());
    }

    /**
     * Add finders by configs
     *
     * @param array $configs
     *
     * @return Builder this
     */

    protected function addFindersByConfigs(array $configs)
    {
        foreach ($configs as $package => $path)
        {
            $data = @include $path;

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
     *
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
     * @return RouterAbstract this
     */

    protected function requireFiles()
    {
        foreach ($this->_finders as $finder)
        {
            foreach ($finder as $file)
            {
                require_once $file->getRealpath();
            }
        }

        return $this;
    }

    /**
     * Get config files by composer
     *
     * @return Builder
     */

    protected function getConfigFilesByComposer()
    {
        $this->getLogger()->write('<info>Searching for ".apishla" files</info>');

        $configs = array();
        if ($this->isDependantPackage($this->getEvent()->getComposer()->getPackage()))
        {
            $path = $this->getConfigPackagePath(
                rtrim($this->getRootPackagePath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR,
                $this->getEvent()->getComposer()->getPackage()
            );

            if ($path)
                $configs[$this->getEvent()->getComposer()->getPackage()->getName()] = $path;
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
                    $configs[$package->getName()] = $path;
            }
        }

        ksort($configs);

        Cacher::getInstance()->set(
            $this->getConfigsCacheName(),
            $configs
        );

        return $configs;
    }

    /**
     * Get config package file path
     *
     * @param string           $dir
     * @param PackageInterface $package
     *
     * @return null|string
     */

    protected function getConfigPackagePath($dir, $package)
    {
        $dir = preg_replace(
            '#^(' . preg_quote(getcwd() . DIRECTORY_SEPARATOR, '#') . ')#',
            '.' . DIRECTORY_SEPARATOR,
            $dir
        );

        $path = $this->getConfigPath($dir);
        if (file_exists($path))
        {
            $this->getLogger()->write(
                sprintf(
                    '  - Found in <info>%s</info>',
                    $package->getPrettyName()
                )
            );

            return $path;
        }

        return;
    }

    /**
     * Get configs cache name
     *
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
     *
     * @return string
     */

    protected function getConfigPath($folder)
    {
        return rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.apishka.php';
    }

    /**
     * Returns true if the supplied package requires the Composer NPM bridge.
     *
     * @param PackageInterface $package  the package to inspect
     * @param bool|null        $dev_mode true if the dev dependencies should also be inspected
     *
     * @return bool true if the package requires the bridge
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
     *
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
     *
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

    /**
     * Set root path
     *
     * @param string $path
     *
     * @return Builder this
     */

    public function setRootPackagePath($path)
    {
        $this->_root_package_path = $path;

        return $this;
    }

    /**
     * Get root path
     *
     * @return string
     */

    public function getRootPackagePath()
    {
        if ($this->_root_package_path === null)
            $this->_root_package_path = './';

        return $this->_root_package_path;
    }
}
