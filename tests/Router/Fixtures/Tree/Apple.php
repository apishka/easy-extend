<?php namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Apple
 */

class Apple extends TreeAbstract
{
    /**
     * Apishka supported keys
     */

    public function __apishkaSupportedKeys()
    {
        return array(
            'apple',
        );
    }
}
