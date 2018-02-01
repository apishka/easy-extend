<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Meta;

class Generator
{
    /**
     * @var Data[]
     */
    private $_datas = [];

    /**
     * @param Data $data
     *
     * @return $this
     */
    public function register(Data $data)
    {
        $this->_datas[] = $data;

        return $this;
    }

    /**
     * @return array
     */
    private function getMetas(): array
    {
        $metas = [];
        foreach ($this->_datas as $data)
        {
            $metas[] = $data->generate();
        }

        return $metas;
    }

    /**
     * @param string $filename
     * @return bool
     */
    public function generate(string $filename): bool
    {
        $this->writeFile(
            $filename,
            $this->generateContents()
        );

        return true;
    }

    /**
     * @return string
     */
    private function generateContents(): string
    {
        $metas = array_filter($this->getMetas());

        $template = <<<TPL
<?php

namespace PHPSTORM_META
{
{meta}
}
TPL;

        $replaces = [
            '{meta}' => implode(PHP_EOL . PHP_EOL, $metas),
        ];

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $template
        );
    }

    /**
     * @param string $filename
     * @param string $contents
     */
    private function writeFile(string $filename, string $contents)
    {
        $dir = '.phpstorm.meta.php';

        if (!file_exists($dir))
        {
            mkdir($dir, 0755);
        }

        file_put_contents(
            $dir . DIRECTORY_SEPARATOR . $filename,
            $contents
        );
    }
}