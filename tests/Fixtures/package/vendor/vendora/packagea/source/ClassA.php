<?php declare(strict_types = 1);

namespace VendorA\PackageA;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Class A
 */
class ClassA implements ByKeyInterface
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
            'classa',
        );
    }
}
