<?php namespace Apishka\EasyExtend\Helper;

use Apishka\EasyExtend\Broker;

/**
 * By class name help trait
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

trait ByClassNameTrait
{
    /**
     * Call static
     *
     * @param string $name
     * @param array  $arguments
     * @static
     *
     * @return mixed
     */

    public static function __callStatic($name, ...$arguments)
    {
        $data = Broker::getInstance()->getRouter('Apishka\EasyExtend\Router\ByClassName')
            ->getItemData(get_called_class())
        ;

        if (preg_match('#^(' . $data['prefixes'] . ')([\w\d_]*)$#', $name, $match))
        {
            if (method_exists($data['class'], $method = '__' . $match[1]))
                return $data['class']::$method($data, $match[2], $arguments);
        }

        throw new \BadMethodCallException('Static function ' . var_export($name, true) . ' not found for class ' . var_export($data['class'], true));
    }

    /**
     * Call static apishka
     *
     * @param array  $data
     * @param string $name
     * @param array  $arguments
     * @static
     *
     * @return mixed
     */

    protected static function __apishka(array $data, $name, array $arguments)
    {
        return new $data['class'](...$arguments);
    }

    /**
     * Returns static prefixes
     *
     * @return string
     */

    public function __apishkaGetPrefixes()
    {
        return 'apishka';
    }
}
