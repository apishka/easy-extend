<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Command;

use Apishka\EasyExtend\Meta;
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
        $generator = new Meta\Generator();

        $generator->register(
            $this->generateMetaDataForRouter(Broker::getInstance(), 'getRouter')
        );

        $generator->register(
            $this->generateMetaDataForRouter(Broker::getInstance()->getRouter(Locator\ByClassName::class), 'make')
        );

        $generator->generate('easy-extend.meta.php');
    }

    /**
     * @param RouterAbstract $router
     * @param string $function
     * @return Meta\Data
     */
    private function generateMetaDataForRouter(RouterAbstract $router, string $function): Meta\Data
    {
        $data = new Meta\Data(get_class($router), $function);

        foreach ($router->getData() as $key => $details)
        {
            $data->map(
                '\\' . $key,
                true,
                '\\' . $details['class'] . '::class',
                false
            );
        }

        return $data;
    }
}
