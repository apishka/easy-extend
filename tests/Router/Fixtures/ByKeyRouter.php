<?php

namespace ApishkaTest\EasyExtend\Router\Fixtures;

use Apishka\EasyExtend\Router\ByKeyAbstract;

/**
 * By key router
 */

class ByKeyRouter extends ByKeyAbstract
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
        return $this->hasClassInterface($reflector, 'Apishka\EasyExtend\Helper\ByKeyInterface');
    }
}
