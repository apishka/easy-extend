<?php declare(strict_types = 1);

namespace Apishka\EasyExtend;

/**
 * Router abstract
 */
abstract class RouterAbstract
{
    /**
     * Cache
     *
     * @var array|null
     */
    private $_cache;

    /**
     * Apishka
     *
     * @return static
     */
    public static function apishka()
    {
        return Broker::getInstance()->getRouter(get_called_class());
    }

    /**
     * Cache
     */
    public function cache(): void
    {
        Cacher::getInstance()->set(
            $this->getCacheName(),
            array_replace(
                array(
                    'class' => get_class($this),
                ),
                $this->getCacheData()
            )
        );
    }

    /**
     * Get cache data
     *
     * @return array
     */
    protected function getCacheData(): array
    {
        $data = array(
            'data'  => array(),
        );

        foreach (get_declared_classes() as $class)
        {
            $reflector = new \ReflectionClass($class);

            if ($this->isCorrectAbstractItem($reflector) && $this->isCorrectItem($reflector))
                $data = $this->pushClassData($data, $reflector);
        }

        return $data;
    }

    /**
     * Push class data
     *
     * @param array            $data
     * @param \ReflectionClass $reflector
     *
     * @return array
     */
    protected function pushClassData(array $data, \ReflectionClass $reflector): array
    {
        return $this->collectClassData(
            $reflector->newInstanceWithoutConstructor(),
            $data,
            $reflector
        );
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
    protected function collectClassData($item, array $data, \ReflectionClass $reflector): array
    {
        foreach ($this->getClassVariants($reflector, $item) as $name)
        {
            $key = $this->getItemKey($name);

            if (!array_key_exists($key, $data['data']) || $this->isItemGreedy($data['data'][$key], $reflector, $item))
                $data = $this->addClassData($data, $key, $reflector, $item, $name);
        }

        return $data;
    }

    /**
     * Add class data
     *
     * @param array            $data
     * @param string           $key
     * @param \ReflectionClass $reflector
     * @param object           $item
     * @param mixed            $variant
     *
     * @return array
     */

    protected function addClassData(array $data, string $key, \ReflectionClass $reflector, $item, $variant): array
    {
        $data['data'][$key] = $this->getClassData($reflector, $item, $variant);

        return $data;
    }

    /**
     * Get class data
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     * @param mixed            $variant
     *
     * @return array
     */
    protected function getClassData(\ReflectionClass $reflector, $item, $variant): array
    {
        return array(
            'class'     => $reflector->getName(),
        );
    }

    /**
     * Get class variants
     *
     * @param \ReflectionClass $reflector
     * @param object           $item
     *
     * @return array
     */
    protected function getClassVariants(\ReflectionClass $reflector, $item): array
    {
        return array(
            $this->getClassBaseName($item),
        );
    }

    /**
     * Returns true if item is greedy
     *
     * @param array            $info
     * @param \ReflectionClass $reflector
     * @param object           $item
     *
     * @return bool
     */
    protected function isItemGreedy(array $info, \ReflectionClass $reflector, $item): bool
    {
        $base = new \ReflectionClass($info['class']);

        if ($reflector->isSubclassOf($base->getName()))
            return true;

        if (!$base->isSubclassOf($reflector->getName()))
            throw new \LogicException('Class ' . var_export($reflector->getName(), true) . ' has no direct relation with class ' . var_export($base->getName(), true) . '. Use @easy-extend-base to create new branch.');

        return false;
    }

    /**
     * Function to get first not abstract parent
     *
     * @param object $item
     *
     * @return string|null
     */
    protected function getClassBaseName($item): ?string
    {
        $classes = $this->getClassBaseNames($item);

        return array_pop($classes);
    }

    /**
     * Get class base names
     *
     * @param object $item
     *
     * @return array
     */
    protected function getClassBaseNames($item): array
    {
        $basenames = array();
        $reflector = new \ReflectionClass($item);

        do
        {
            if (!$reflector->isAbstract())
            {
                $docComment = $reflector->getDocComment();
                if ($docComment && strpos($docComment, '@easy-extend-base') !== false)
                {
                    $basenames[] = $reflector->getName();

                    return $basenames;
                }

                $basenames[] = $reflector->getName();
            }

            $parent = $reflector->getParentClass();

            if (!$parent)
                break;

            $reflector = new \ReflectionClass($parent->getName());
        }
        while (true);

        return $basenames;
    }

    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */
    abstract protected function isCorrectItem(\ReflectionClass $reflector): bool;

    /**
     * Is correct abstract item
     *
     * @param \ReflectionClass $reflector
     *
     * @return bool
     */
    protected function isCorrectAbstractItem(\ReflectionClass $reflector): bool
    {
        if ($reflector->isAbstract())
            return $this->collectAbstractItems();

        return true;
    }

    /**
     * Collect abstract items
     *
     * @return bool
     */
    protected function collectAbstractItems(): bool
    {
        return false;
    }

    /**
     * Get class traits
     *
     * @param \ReflectionClass $reflector
     *
     * @return array
     */
    protected function getClassTraits(\ReflectionClass $reflector): array
    {
        $class = $reflector->getName();

        $traits = array();

        do
        {
            $traits = array_merge(class_uses($class), $traits);
        }
        while ($class = get_parent_class($class));

        foreach ($traits as $trait)
            $traits = array_merge(class_uses($trait), $traits);

        return array_keys(array_unique($traits));
    }

    /**
     * Get class interfaces
     *
     * @param \ReflectionClass $reflector
     *
     * @return array
     */

    protected function getClassInterfaces(\ReflectionClass $reflector): array
    {
        return array_values($reflector->getInterfaceNames());
    }

    /**
     * Has class trait
     *
     * @param \ReflectionClass $reflector
     * @param string           $trait
     *
     * @return bool
     */
    protected function hasClassTrait(\ReflectionClass $reflector, string $trait): bool
    {
        return in_array($trait, $this->getClassTraits($reflector));
    }

    /**
     * Has class interface
     *
     * @param \ReflectionClass $reflector
     * @param string           $interface
     *
     * @return bool
     */
    protected function hasClassInterface(\ReflectionClass $reflector, string $interface): bool
    {
        return in_array($interface, $this->getClassInterfaces($reflector));
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->loadCache()['data'];
    }

    /**
     * Load cache
     *
     * @return array
     */
    protected function loadCache(): array
    {
        if ($this->_cache === null)
            $this->_cache = Cacher::getInstance()->get($this->getCacheName());

        return $this->_cache;
    }

    /**
     * Get item
     *
     * @param string|array $name
     *
     * @return object
     */
    public function getItem($name)
    {
        if (func_num_args() > 1)
            $name = func_get_args();

        $info  = $this->getItemData($name);
        $class = $info['class'];

        return new $class();
    }

    /**
     * Get items list
     *
     * @return array
     */
    public function getItemsList(): array
    {
        return array_keys($this->getData());
    }

    /**
     * Get item data
     *
     * @param string|array $name
     *
     * @return array
     */
    public function getItemData($name): array
    {
        if (func_num_args() > 1)
            $name = func_get_args();

        if (!$this->hasItemData($name))
            return $this->getItemDataNotFound($name);

        return $this->getData()[$this->getItemKey($name)];
    }

    /**
     * Has item data
     *
     * @param string|array $name
     *
     * @return bool
     */
    public function hasItemData($name): bool
    {
        if (func_num_args() > 1)
            $name = func_get_args();

        return array_key_exists($this->getItemKey($name), $this->getData());
    }

    /**
     * Returns item key
     *
     * @param string|array $name
     *
     * @return string
     */
    public function getItemKey($name): string
    {
        if (func_num_args() > 1)
            $name = func_get_args();

        if (is_array($name))
            return implode('|', $name);

        return (string) $name;
    }

    /**
     * Item data not found
     *
     * @param string|array $name
     */
    protected function getItemDataNotFound($name)
    {
        throw new \LogicException('Item with name ' . var_export($name, true) . ' not found');
    }

    /**
     * Get cache path
     *
     * @return string
     */
    public function getCacheName(): string
    {
        return str_replace('\\', '_', get_class($this));
    }
}
