<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\Broker;
use Symfony\Component\Finder\Finder;

/**
 * Builder
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Builder
{
    /**
     * Finders
     *
     * @type array
     * @access private
     */

    private $_finders = array();

    /**
     * Build
     *
     * @param Event $event
     * @access public
     * @return void
     */

    public function buildFromEvent(Event $event)
    {
        // 1. Найти список нужных пакетиков
        // 2. Обыскать пакетики на предмет апишечек
        // 3. Создать файндеры для поиска файликов
        // 4. Создать билдер и запилить кешик
    }

    public function buildFromCache()
    {
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

        $broker = new Broker();
        $broker->cache();

        foreach ($broker->getData() as $class)
        {
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
}
