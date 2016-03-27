<?php namespace ApishkaTest\EasyExtend\Router\Fixtures;

use Apishka\EasyExtend\Helper\ByClassNameTrait;
use Apishka\EasyExtend\Helper\ByKeyInterface;

/**
 * Tree abstract
 */

abstract class TreeAbstract implements ByKeyInterface
{
    /**
     * Traits
     */

    use ByClassNameTrait;
}
