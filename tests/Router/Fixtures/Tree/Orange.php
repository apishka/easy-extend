<?php namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

use ApishkaTest\EasyExtend\Router\Fixtures\TreeAbstract;

/**
 * Orange
 *
 * @uses TreeAbstract
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
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
