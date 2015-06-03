<?php namespace Apishka\EasyExtend\Type;

/**
 * By class name trait
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

trait ByClassNameTrait
{
    /**
     * Call static
     *
     * @param string    $name
     * @param array     $arguments
     * @static
     * @access public
     * @return mixed
     */

    public static function __callStatic($name, ...$arguments)
    {
        $current = get_called_class();

        $data = array(
            'class'     => $current,
            'prefixes'  => 'apishka',
        );

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
     * @param array $data
     * @param string $name
     * @param array $arguments
     * @static
     * @access protected
     * @return mixed
     */

    protected static function __apishka(array $data, $name, array $arguments)
    {
        return new $data['class'](...$arguments);
    }

    /**
     * Returns static prefixes
     *
     * @access protected
     * @return string
     */

    protected function __apishkaPrefixes()
    {
        return 'apishka';
    }
}
