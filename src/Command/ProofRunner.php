<?php

namespace CodingAvenue\Proof\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use CodingAvenue\Proof\BinFinder;
use CodingAvenue\Proof\Config;
use CodingAvenue\Proof\CLI\AnswerFileFinder;

class ProofRunner extends Command
{
    /**
     * Configure the arguments and options
     */
    protected function configure()
    {
        $this
            ->setName("codingavenue:proof-runner")
            ->setDescription("Test Runner command, allows authors to create a test code to used by their proof files")
            ->addArgument('proof', InputArgument::REQUIRED, 'The proof file run by the Test Runner.')
            ->addArgument('answer', InputArgument::REQUIRED, 'The answer code to be test against the Test Runner.');
    }

    /**
     * Run the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $proof = $input->getArgument('proof');
        $answer = $input->getArgument('answer');

        if ($input->getOption('verbose')) {
            $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        }

        $output->writeln("Loading configuration file", OutputInterface::VERBOSITY_VERBOSE);

        $config = new Config($answer);
        $binFinder = new BinFinder($config);

        $out = array();
        $phpUnit = $binFinder->getPHPUnit();
        $output->writeln("Running command `{$phpUnit} --verbose --tap {$proof}`", OutputInterface::VERBOSITY_VERBOSE);

        if (PHP_OS === 'WINNT') {
            exec("set TEST_INDEX={$answer} {$phpUnit} --verbose --tap {$proof}", $out);
        } else {
            exec("TEST_INDEX={$answer} {$phpUnit} --verbose --tap {$proof}", $out);
        }

        foreach ($out as $line) {
            $output->writeln($line);
        }
    }
}
