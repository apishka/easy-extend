<?php namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Orange
 */

class Orange extends TreeAbstract
{
    /**
     * Apishka supported keys
     */

    public function __apishkaSupportedKeys()
    {
        return array(
            'orange',
        );
    }
}
