<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Router;

use Apishka\EasyExtend\RouterAbstract;

/**
 * By key abstract
 */
abstract class ByKeyAbstract extends RouterAbstract
{
    /**
     * Get class variants
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     *
     * @return array
     */
    protected function getClassVariants(\ReflectionClass $reflector, $item): array
    {
        return $item->__apishkaSupportedKeys();
    }
}
