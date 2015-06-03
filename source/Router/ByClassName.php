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

    /**
     * Push class data
     *
     * @param array $data
     * @param \ReflectionClass $reflector
     * @access protected
     * @return array
     */

    protected function pushClassData(array $data, \ReflectionClass $reflector)
    {
        $data[$reflector->getName()] = $reflector->getName();

        return $data;
    }
}
