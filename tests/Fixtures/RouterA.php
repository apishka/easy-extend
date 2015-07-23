<?php namespace ApishkaTest\EasyExtend\Fixtures;

use Apishka\EasyExtend\RouterAbstract;

/**
 * RouterA
 *
 * @uses RouterAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class RouterA extends RouterAbstract
{
    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        return false;
    }
}
