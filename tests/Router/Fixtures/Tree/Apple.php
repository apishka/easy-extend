<?php declare(strict_types = 1);

namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Apple
 */
class Apple extends TreeAbstract
{
    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array
    {
        return array(
            'apple',
        );
    }
}
