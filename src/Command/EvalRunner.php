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

        $content = $this->prepareCode($file);

        $additionalCode = $input->getOption('additional-code');

        if (!is_null($additionalCode)) {
            $content = implode(" ", array($content, $additionalCode));
        }

        ob_start();
        try {
            $result = eval($content);
            $out = ob_get_clean();

            $output->writeln(json_encode(array('result' => $result, 'output' => trim($out))));
        }
        catch(\Error $e) {
            $out = ob_get_clean();
            
            $output->writeln(json_encode(array('error' => $e->getMessage() . ' at line ' . $e->getLine(), 'output' => trim($out))));
        }
    }

    private function prepareCode(string $file): string
    {
        $content = file_get_contents($file);

        $content = preg_replace("/^\<\?php/", '', $content);
        $content = preg_replace("/\?\>$/", '', $content);

        return $content;
    }
}
