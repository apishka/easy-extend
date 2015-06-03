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
     * @type \AppendIterator
     * @access private
     */

    private $_finders = null;

    /**
     * Add finder
     *
     * @param Finder $finder
     * @access public
     * @return RouterAbstract this
     */

    public function addFinder(Finder $finder)
    {
        if ($this->_finders === null)
            $this->_finders = new \AppendIterator();

        $this->_finders->append($finder);

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
        foreach ($this->_finders as $file)
        {
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
