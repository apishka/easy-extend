<?php declare(strict_types = 1);

namespace VendorB\PackageB;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Class B
 */
class ClassB implements ByKeyInterface
{
    /**
     * Traits
     */
    use ByClassNameTrait;

    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array
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
    public function __apishkaGetPrefixes(): string
    {
        return 'apishka|testishka';
    }
}
