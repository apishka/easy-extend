<?php

namespace ApishkaTest\EasyExtend\Router\Fixtures\Tree;

/**
 * Mandarin
 *
 * @easy-extend-base
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
