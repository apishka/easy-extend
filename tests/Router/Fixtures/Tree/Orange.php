<?php declare(strict_types = 1);

namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Orange
 */
class Orange extends TreeAbstract
{
    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array
    {
        return array(
            'orange',
        );
    }
}
