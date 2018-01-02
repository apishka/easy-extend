<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Helper;

/**
 * By class name help trait
 */
interface ByKeyInterface
{
    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array;
}
