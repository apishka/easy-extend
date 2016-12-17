<?php

namespace Apishka\EasyExtend;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

/**
 * Easy extend
 */

class EasyExtend implements PluginInterface, EventSubscriberInterface
{
    /**
     * Builder
     *
     * @var Builder
     */

    private $_builder = null;

    /**
     * Activate the plugin.
     *
     * @param Composer    $composer the main Composer object
     * @param IOInterface $io       the i/o interface to use
     */

    public function activate(Composer $composer, IOInterface $io)
    {
        // no action required
    }

    /**
     * Get the event subscriber configuration for this plugin.
     *
     *
     * @return array<string,string> the events to listen to, and their associated handlers
     */

    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::POST_INSTALL_CMD  => 'onPostInstallCmd',
            ScriptEvents::POST_UPDATE_CMD   => 'onPostInstallCmd',
        );
    }

    /**
     * Handle post install command events.
     *
     * @param Event $event the event to handle
     */

    public function onPostInstallCmd(Event $event)
    {
        $this->getBuilder()
            ->buildFromEvent($event)
        ;
    }

    /**
     * Sets builder
     *
     * @param Builder $builder
     *
     * @return EasyExtend this
     */

    public function setBuilder(Builder $builder)
    {
        $this->_builder = $builder;

        return $this;
    }

    /**
     * Get builder
     *
     * @return \Apishka\EasyExtend\Builder
     */

    public function getBuilder()
    {
        if ($this->_builder === null)
            $this->_builder = new Builder();

        return $this->_builder;
    }
}
