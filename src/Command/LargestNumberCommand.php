<?php

namespace App\Command;

use App\Controller\LargestNumberController;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LargestNumberCommand extends Command
{
    protected static $defaultName = 'app:find-largest-number';

    protected function configure()
    {
        $this
            ->setDescription('Sprawdzanie najwieszej liczby w ciągu')
            ->setHelp('Komenda pozwala na sprawdzenie największej liczby w ciągu');

        $this->addArgument('number', InputArgument::REQUIRED, 'Liczba n (1 ≤ n ≤ 99 999)');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input = $input->getArgument('number');
        $largestNumberController = new LargestNumberController;
        $result = $largestNumberController->getData($input);
        $output->writeln($result);

    }
}
