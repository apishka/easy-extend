<?php namespace ApishkaTest\EasyExtend\Router\Fixtures;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Tree abstract
 *
 * @abstract
 *
 * @uses ByKeyInterface
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class TreeAbstract implements ByKeyInterface
{
    /**
     * Traits
     */

    use ByClassNameTrait;
}
