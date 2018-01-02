<?php declare(strict_types = 1);

namespace ApishkaTest\EasyExtend\Fixtures;

use Apishka\EasyExtend\RouterAbstract;

/**
 * RouterA
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
    protected function isCorrectItem(\ReflectionClass $reflector): bool
    {
        return false;
    }
}
