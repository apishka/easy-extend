<?php namespace Apishka\EasyExtend;

use Apishka\EasyExtend\Type\ByClassNameTrait;
use Apishka\EasyExtend\RouterInterface;

/**
 * Router abstract
 *
 * @abstract
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

abstract class RouterAbstract implements RouterInterface
{
    /**
     * Traits
     */

    use ByClassNameTrait;

    /**
     * Cache
     *
     * @type array
     * @access private
     */

    private $_cache = null;

    /**
     * Cache
     *
     * @access public
     * @return void
     */

    public function cache()
    {
        $data = $this->getCacheData();

        Cacher::getInstance()->save(
            $this->getCacheName(),
            array(
                'class' => get_class($this),
                'data'  => $data,
            )
        );
    }

    /**
     * Get cache data
     *
     * @access protected
     * @return array
     */

    protected function getCacheData()
    {
        $data = array();

        foreach (get_declared_classes() as $class)
        {
            $reflector = new \ReflectionClass($class);

            if ($this->isCorrectItem($reflector))
                $data = $this->pushClassData($data, $reflector);
        }

        return $data;
    }

    /**
     * Push class data
     *
     * @param array $data
     * @param \ReflectionClass $reflector
     * @access protected
     * @return array
     */

    protected function pushClassData(array $data, \ReflectionClass $reflector)
    {
        $item = $reflector->newInstanceWithoutConstructor();

        foreach ($this->getClassVariants($reflector, $item) as $key)
        {
            if (!array_key_exists($key, $data) || $this->isItemGreedy($data[$key], $reflector, $item))
                $data[$key] = $this->getClassData($reflector, $item);
        }

        return $data;
    }

    /**
     * Get class data
     *
     * @param \ReflectionClass $reflector
     * @param object $item
     * @access protected
     * @return mixed
     */

    protected function getClassData(\ReflectionClass $reflector, $item)
    {
        return array(
            'class'     => $reflector->getName(),
        );
    }

    /**
     * Get class variants
     *
     * @param \ReflectionClass $reflector
     * @param object $item
     * @access protected
     * @return array
     */

    protected function getClassVariants(\ReflectionClass $reflector, $item)
    {
        return array(
            $this->getClassBaseName($item),
        );
    }

    /**
     * Returns true if item is greedy
     *
     * @param array $info
     * @param \ReflectionClass $reflector
     * @param object $item
     * @access protected
     * @return bool
     */

    protected function isItemGreedy(array $info, \ReflectionClass $reflector, $item)
    {
        $base = new \ReflectionClass($info['class']);

        if ($reflector->isSubclassOf($base->getName()))
            return true;

        return false;
    }

    /**
     * Function to get first not abstract parent
     *
     * @param object $item
     * @access protected
     * @return string
     */

    protected function getClassBaseName($item)
    {
        $basename   = null;
        $reflector  = new \ReflectionClass($item);

        do
        {
            if (!$reflector->isAbstract())
            {
                if (strpos($reflector->getDocComment(), '@easy-extend-base') !== false)
                    return $reflector->getName();

                $basename = $reflector->getName();
            }

            $parent = $reflector->getParentClass();

            if (!$parent)
                break;

            $reflector = new \ReflectionClass($parent->getName());
        }
        while (true);

        return $basename;
    }

    /**
     * Is correct item
     *
     * @param \ReflectionClass $reflector
     * @access protected
     * @return bool
     */

    protected function isCorrectItem(\ReflectionClass $reflector)
    {
        return !$reflector->isAbstract();
    }

    /**
     * Get class traits
     *
     * @param \ReflectionClass $reflector
     * @access protected
     * @return array
     */

    protected function getClassTraits(\ReflectionClass $reflector)
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
     * @access protected
     * @return array
     */

    protected function getClassInterfaces(\ReflectionClass $reflector)
    {
        return array_values($reflector->getInterfaceNames());
    }

    /**
     * Has class trait
     *
     * @param \ReflectionClass $reflector
     * @param string $trait
     * @access protected
     * @return bool
     */

    protected function hasClassTrait(\ReflectionClass $reflector, $trait)
    {
        return in_array($trait, $this->getClassTraits($reflector));
    }

    /**
     * Has class interface
     *
     * @param \ReflectionClass $reflector
     * @param string $interface
     * @access protected
     * @return bool
     */

    protected function hasClassInterface(\ReflectionClass $reflector, $interface)
    {
        return in_array($interface, $this->getClassInterfaces($reflector));
    }

    /**
     * Get data
     *
     * @access public
     * @return array
     */

    public function getData()
    {
        if ($this->_cache === null)
            $this->_cache = Cacher::getInstance()->fetch($this->getCacheName());

        return $this->_cache['data'];
    }

    /**
     * Get cache path
     *
     * @access public
     * @return string
     */

    public function getCacheName()
    {
        return str_replace('\\', '_', get_class($this));
    }
}
