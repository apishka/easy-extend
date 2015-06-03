<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\Type\ByClassNameTrait;
use Symfony\Component\Finder\Finder;

/**
 * Router abstract
 *
 * @abstract
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class RouterAbstract
{
    /**
     * Traits
     */

    use ByClassNameTrait;

    /**
     * Finders
     *
     * @type array
     * @access private
     */

    private $_finders = array();

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
     * Cache
     *
     * @access public
     * @return void
     */

    public function cache()
    {
        $this->requireFiles();
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
     * Get cache path
     *
     * @access public
     * @return string
     */

    public function getCacheName()
    {
        return str_replace('\\', '_', get_class($this));
    }
}
