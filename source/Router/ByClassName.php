<?php

namespace Apishka\EasyExtend\Router;

use Apishka\EasyExtend\RouterAbstract;

/**
 * By class name
 */

class ByClassName extends RouterAbstract
{
    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        return $this->hasClassTrait($reflector, 'Apishka\EasyExtend\Helper\ByClassNameTrait');
    }

    /**
     * Get class data
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     * @param mixed            $variant
     *
     * @return mixed
     */

    protected function getClassData(\ReflectionClass $reflector, $item, $variant)
    {
        $data             = parent::getClassData($reflector, $item, $variant);
        $data['prefixes'] = $item->__apishkaGetPrefixes();

        return $data;
    }

    /**
     * Collect class data
     *
     * @param object           $item
     * @param array            $data
     * @param \ReflectionClass $reflector
     *
     * @return array
     */

    protected function collectClassData($item, array $data, \ReflectionClass $reflector)
    {
        $data = parent::collectClassData($item, $data, $reflector);

        if (!array_key_exists('mapping', $data))
            $data['mapping'] = array();

        $basename = $this->getClassBaseName($item);
        foreach ($this->getClassBaseNames($item) as $name)
        {
            if ($basename !== $name)
                $data['mapping'][$name] = $basename;
        }

        return $data;
    }

    /**
     * Get mapping
     *
     * @return array
     */

    public function getMapping()
    {
        return $this->loadCache()['mapping'];
    }

    /**
     * Item data not found
     *
     * @param string $name
     */

    protected function getItemDataNotFound($name)
    {
        if (array_key_exists($name, $this->getMapping()))
            return $this->getItemData($this->getMapping()[$name]);

        return parent::getItemDataNotFound($name);
    }
}
