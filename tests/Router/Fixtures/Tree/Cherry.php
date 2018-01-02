<?php declare(strict_types = 1);

namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Cherry
 */
class Cherry extends TreeAbstract
{
    /**
     * @return array
     */
    public function __apishkaSupportedKeys(): array
    {
        return array(
            'cherry',
        );
    }
}
