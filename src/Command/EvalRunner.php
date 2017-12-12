<?php

namespace CodingAvenue\Proof\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EvalRunner extends Command
{
    /**
     * Configure the arguments and options
     */
    protected function configure()
    {
        $this
            ->setName("codingavenue:eval-runner")
            ->setDescription("Eval Runner command, run the eval'd code on a separate process")
            ->addArgument('file', InputArgument::REQUIRED, 'The php file to be evaluated')
            ->addOption('additional-code', null, InputOption::VALUE_REQUIRED, 'Additional php code to be appended on the evaluated code');
    }

    /**
     * Run the command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
        if (!file_exists($file)) {
            $output->writeln(json_encode(array('error' => "File {$file} not found")));
            return;
        }

        $additionalCode = $input->getOption('additional-code') || '';        

        // Temporary disable injecting additional code. Will handle it properly later on.
        //$this->finalizeFile($file, $additionalCode);

        $command = "php $file 2>&1";

        $out;
        try {
            exec($command, $out, $result);

            if ($result === 0) {
                $output->writeln(
                    json_encode(
                        array(
                            'output' => implode("\n", $out)
                        )
                    )
                );
            }
            else {
                $out = implode(" ", $out);
                $out = str_replace(" in " . realpath($file), '', $out);
                $output->writeln(
                    json_encode(
                        array(
                            'error' => $out
                        )
                    )
                );
            }
        }
        catch(\Error $e) {
            $output->writeln(json_encode(array('error' => $e->getMessage() . ' at line ' . $e->getLine(), 'output' => trim(implode("\n", $out)))));
        }
    }

    private function finalizeFile(string $file, string $additionalCode = '')
    {
        $content = file_get_contents($file);

        $content = trim($content);

        if (preg_match("/\?\>$/", $content) === 1) {
            $content = preg_replace("/\?\>$/", '', $content);
            $content = implode(" ", array($content, $additionalCode, "?>"));
        }
        else {
            $content = implode(" ", array($content, $additionalCode));
        }

        $fh = fopen($file, 'w');
        fwrite($fh, $content);
        fclose($fh);
    }
}
