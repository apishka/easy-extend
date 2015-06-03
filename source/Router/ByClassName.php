<?php namespace Apishka\EasyExtend\Router;

use Apishka\EasyExtend\RouterAbstract;

/**
 * By class name
 *
 * @uses RouterAbstract
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class ByClassName extends RouterAbstract
{
    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     * @access protected
     * @return bool
     */

    protected function isCorrectItem($reflector)
    {
        return parent::isCorrectItem($reflector) && $this->hasClassTrait($reflector, 'Apishka\EasyExtend\Type\ByClassNameTrait');
    }
}
