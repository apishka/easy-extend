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
    }

    /**
     * Get cache path
     *
     * @access public
     * @return void
     */

    public function getCacheFile()
    {
        return realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cache');
    }
}
