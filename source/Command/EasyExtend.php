<?php declare(strict_types = 1);

namespace Apishka\EasyExtend\Command;

use Apishka\EasyExtend\Builder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Apishka easy extend command
 */
class EasyExtend extends Command
{
    /**
     * Result
     *
     * @var array
     */
    private $_result = array();

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('apishka:easy-extend')
            ->setDescription('Easy extend')
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
        $output->writeln('Apishka Easy Extend config generation');

        $builder = new Builder();
        $builder->buildFromCache();

        $output->writeln('Done');
    }
}
