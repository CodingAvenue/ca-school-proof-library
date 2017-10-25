<?php

namespace CodingAvenue\Proof;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Evaluator
{
    /* @var string $file the php file to be evaluated */
    private $file;

    /** @var BinFinder $binFinder the BinFinder instance */
    private $binFinder;

    /**
     * Evaluator class - evaluates a php file into an isolated process.
     * Returns the result of the evaluated code and (if any) the output of the code
     * throws an error if the code has a parsing error.
     */
    public function __construct(string $file, string $binFinder)
    {
        $this->file = $file;
        $this->binFinder = $binFinder;
    }

    /**
     * Evaluates the code. Accepts an optional additional code that will be appended to the existing code
     * Useful if you want to output some values
     *
     * @param string|null $code a string of code that will be appended
     * @return the result of the evaluated code and it's output
     */
    public function evaluate($code = null): array
    {
        $process = new Process($this->prepareCommand($code));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process); 
        }
        
        return json_decode($process->getOutput(), true);
    }

    public function prepareCommand($code = null)
    {
        $command = array();
        $command[] = $this->binFinder;

        if (!is_null($code)) {
            $command[] = "--additional-code $code";
        }

        $command[] = $this->file;

        return implode(" ", $command);
    }
}
