<?php namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

/**
 * Mandarin
 *
 * @easy-extend-base
 *
 * @uses Orange
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class Mandarin extends Orange
{
    /**
     * Apishka supported keys
     */

    public function __apishkaSupportedKeys()
    {
        return array(
            'mandarin',
        );
    }
}
