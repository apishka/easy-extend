<?php namespace VendorA\PackageA;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Class A
 *
 * @uses ByKeyInterface
 *
 * @author Alexander "grevus" Lobtsov <alex@lobtsov.com>
 */

class ClassA implements ByKeyInterface
{
    /**
     * Traits
     */

    use ByClassNameTrait;

    /**
     * Apishka supported keys
     */

    public function __apishkaSupportedKeys()
    {
        return array(
            'classa',
        );
    }
}
