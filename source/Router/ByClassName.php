<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Router;

use Apishka\EasyExtend\RouterAbstract;

/**
 * By class name
 */
class ByClassName extends RouterAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function isCorrectItem(\ReflectionClass $reflector): bool
    {
        return $this->hasClassTrait($reflector, 'Apishka\EasyExtend\Helper\ByClassNameTrait');
    }

    /**
     * {@inheritdoc}
     */
    protected function getClassData(\ReflectionClass $reflector, $item, $variant): array
    {
        $data             = parent::getClassData($reflector, $item, $variant);
        $data['prefixes'] = $item->__apishkaGetPrefixes();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    protected function collectClassData($item, array $data, \ReflectionClass $reflector): array
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
    public function getMapping(): array
    {
        return $this->loadCache()['mapping'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getItemDataNotFound($name)
    {
        if (array_key_exists($name, $this->getMapping()))
            return $this->getItemData($this->getMapping()[$name]);

        return parent::getItemDataNotFound($name);
    }
}
