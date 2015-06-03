<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\RouterAbstract;

/**
 * Broker
 *
 * @uses RouterAbstract
 * @final
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

final class Broker extends RouterAbstract
{
    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     * @access protected
     * @return bool
     */

    protected function isCorrectItem($reflector)
    {
        if (!parent::isCorrectItem($reflector))
            return false;

        if ($reflector->isInstance($this))
            return false;

        if (!$this->hasClassInterface($reflector, 'Apishka\EasyExtend\RouterInterface'))
            return false;

        return true;
    }

    /**
     * Get cache data
     *
     * @access protected
     * @return array
     */

    protected function getCacheData()
    {
        $data = parent::getCacheData();

        ksort($data);

        return $data;
    }
}
