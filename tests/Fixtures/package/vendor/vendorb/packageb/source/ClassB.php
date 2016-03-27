<?php namespace VendorB\PackageB;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Class B
 *
 *
 */

class ClassB implements ByKeyInterface
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
            'classb',
        );
    }

    /**
     * Returns static prefixes
     *
     * @return string
     */

    public function __apishkaGetPrefixes()
    {
        return 'apishka|testishka';
    }
}
