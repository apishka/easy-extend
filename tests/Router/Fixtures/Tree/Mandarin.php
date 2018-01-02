<?php declare(strict_types = 1);

namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

/**
 * Mandarin
 *
 * @easy-extend-base
 */
class Mandarin extends Orange
{
    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array
    {
        return array(
            'mandarin',
        );
    }
}
