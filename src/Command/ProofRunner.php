<?php

namespace CodingAvenue\Proof\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->addArgument('files', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'A list of proof files to run by the Test Runner.');
    }

    /**
     * Run the command.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $input->getArgument('files');
        if ($input->getOption('verbose')) {
            $output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);
        }

        $output->writeln("Loading configuration file", OutputInterface::VERBOSITY_VERBOSE);

        $config = new Config();

        $output->writeln("Configuration file loaded", OutputInterface::VERBOSITY_VERBOSE);
        $output->writeln("Preparing files to be executed by phpunit", OutputInterface::VERBOSITY_VERBOSE);

        foreach ($files as $file) {
            if (!$config->isDefaultConfiguration()) {
                $output->writeln("Preparing file {$file}", OutputInterface::VERBOSITY_VERBOSE);
                $output->writeln("Resolving test file code to be used on this test.", OutputInterface::VERBOSITY_VERBOSE);

                $answerFileFinder = new AnswerFileFinder($config->getAnswerDir(), $config->getProofDir());
                $answerFile = $answerFileFinder->resolve($file);

                $output->writeln("Using test file {$answerFilee} for this test as code input.", OutputInterface::VERBOSITY_VERBOSE);
                $output->writeln("Copying content to {$config->getCodeFilePath()}", OutputInterface::VERBOSITY_VERBOSE);

                $fileHandler = fopen($config->getCodeFilePath(), 'w');
                fwrite($fileHandler, file_get_contents($answerFile));

                $output->writeln("Copy completed.", OutputInterface::VERBOSITY_VERBOSE);
            }

            $out = array();
            $output->writeln("Running command `vendor/bin/phpunit --verbose --tap {$file}`", OutputInterface::VERBOSITY_VERBOSE);

            exec("vendor/bin/phpunit --verbose --tap {$file}", $out);

            foreach ($out as $line) {
                $output->writeln($line);
            }
        }
    }
}
