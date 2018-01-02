<?php declare(strict_types = 1);

namespace VendorA\PackageA;

use Apishka\EasyExtend\Helper\ByKeyInterface;
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
    protected function isCorrectItem(\ReflectionClass $reflector): bool
    {
        return $this->hasClassInterface($reflector, ByKeyInterface::class);
    }
}
