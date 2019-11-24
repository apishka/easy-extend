<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Command;

use Apishka\EasyExtend\Builder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Apishka easy extend command
 */
class Collect extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('collect')
            ->setDescription('Collect easy extend data')
        ;
    }

    /**
     * Execute
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Apishka Easy Extend config generation');

        $builder = new Builder();
        $builder->buildFromCache();

        $output->writeln('Done');
    }
}
