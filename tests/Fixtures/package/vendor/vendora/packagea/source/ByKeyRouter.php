<?php namespace VendorA\PackageA;

use Apishka\EasyExtend\Router\ByKeyAbstract;

/**
 * By key router
 *
 * @uses ByKeyAbstract
 *
 * @author Alexander "grevus" Lobtsov <alex@lobtsov.com>
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
        return parent::isCorrectItem($reflector) && $this->hasClassInterface($reflector, 'Apishka\EasyExtend\Helper\ByKeyInterface');
    }
}
