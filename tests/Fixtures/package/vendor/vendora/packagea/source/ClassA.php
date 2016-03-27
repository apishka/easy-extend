<?php namespace VendorA\PackageA;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Class A
 *
 *
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
