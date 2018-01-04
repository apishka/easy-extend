<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Command;

use Apishka\EasyExtend\Broker;
use Apishka\EasyExtend\Locator;
use Apishka\EasyExtend\RouterAbstract;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Apishka meta generation command
 */
class GenerateMeta extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('generate-meta')
            ->setDescription('Generate PHPStorm meta file')
        ;
    }

    /**
     * Execute
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Apishka Easy Extend meta generation');

        $this->generateMeta();

        $output->writeln('Done');
    }

    /**
     * Generates file with meta
     */
    private function generateMeta(): void
    {
        $metas = [];
        $metas[] = $this->generateMetaForClass(Broker::getInstance(), 'getRouter');
        $metas[] = $this->generateMetaForClass(Broker::getInstance()->getRouter(Locator\ByClassName::class), 'make');

        $this->writeFile(
            $this->prepareMetaFileContents($metas)
        );
    }

    /**
     * Generates meta for classes
     *
     * @param RouterAbstract $router
     * @param string         $function
     *
     * @return string
     */
    private function generateMetaForClass(RouterAbstract $router, string $function): string
    {
        $maps = [];
        foreach ($router->getData() as $key => $data)
        {
            $maps[] = '\'\\' . $key .'\'' . ' => \\' . $data['class'] . '::class';
        }

        return $this->prepareMetaDataForClass(
            get_class($router),
            $function,
            $maps
        );
    }

    /**
     * @param string $contents
     */
    private function writeFile(string $contents)
    {
        $dir = '.phpstorm.meta.php';

        if (!file_exists($dir))
        {
            mkdir($dir, 0755);
        }

        file_put_contents(
            $dir . DIRECTORY_SEPARATOR . 'easy-extend.meta.php',
            $contents
        );
    }

    /**
     * @param string $class
     * @param string $function
     * @param array  $maps
     *
     * @return string
     */
    private function prepareMetaDataForClass(string $class, string $function, array $maps): string
    {
        if (!$maps)
            return '';

        $template = <<<TPL
    override(
        \{class}::{function}(0),
        map(
            //map of argument value -> return type
            [
                {maps}
            ]
        )
    );
TPL;

        $replaces = [
            '{class}' => $class,
            '{function}' => $function,
            '{maps}' => implode(',' . PHP_EOL . '                ', $maps),
        ];

        return str_replace(
            array_keys($replaces),
            array_values($replaces),
            $template
        );
    }

    /**
     * @param array $metas
     *
     * @return string
     */
    private function prepareMetaFileContents(array $metas): string
    {
        $metas = array_filter($metas);

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
}
