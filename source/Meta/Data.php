<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Meta;

class Data
{
    /**
     * @var array
     */
    private $_map = [];

    /**
     * @var string
     */
    private $_class;

    /**
     * @var string
     */
    private $_function;

    /**
     * @param string $class
     * @param string $function
     */
    public function __construct(string $class, string $function)
    {
        $this->_class = $class;
        $this->_function = $function;
    }

    /**
     * @param string $key
     * @param bool   $is_key_string
     * @param string $value
     * @param bool   $is_value_string
     *
     * @return $this
     */
    public function map(string $key, bool $is_key_string, string $value, bool $is_value_string)
    {
        $this->_map[$key] = [
            'value' => $value,
            'is_key_string' => $is_key_string,
            'is_value_string' => $is_value_string,
        ];

        return $this;
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $map = $this->generateMap();
        if (!$map)
            return '';

        $template = <<<TPL
    override(
        \{class}::{function}(0),
        map(
            //map of argument value -> return type
            [
                {map}
            ]
        )
    );
TPL;

        $replaces = [
            '{class}' => $this->_class,
            '{function}' => $this->_function,
            '{map}' => $map,
        ];

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $template
        );
    }

    /**
     * @return string
     */
    private function generateMap(): string
    {
        $maps = [];
        foreach ($this->_map as $key => $data)
        {
            $maps[] = sprintf(
                '%s => %s',
                $this->exportMapValue($key, $data['is_key_string']),
                $this->exportMapValue($data['value'], $data['is_value_string'])
            );
        }

        return implode(',' . PHP_EOL . '                ', $maps);
    }

    /**
     * @param string $value
     * @param bool   $is_string
     *
     * @return string
     */
    private function exportMapValue(string $value, bool $is_string): string
    {
        if (!$is_string)
        {
            return $value;
        }

        return "'" . $value . "'";
    }
}