<?php namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Cherry
 */

class Cherry extends TreeAbstract
{
    /**
     * Apishka supported keys
     */

    public function __apishkaSupportedKeys()
    {
        return array(
            'cherry',
        );
    }
}
