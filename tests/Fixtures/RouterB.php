<?php namespace ApishkaTest\EasyExtend\Fixtures;

use Apishka\EasyExtend\RouterAbstract;

/**
 * RouterB
 */

class RouterB extends RouterAbstract
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
