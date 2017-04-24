<?php

namespace CodingAvenue\Proof;

class Evaluator
{
    /* @var string a string of code to be evaluated */
    private $code;

    /**
     * Evaluator class - evaluates a string of php code.
     * Returns the result of the evaluated code and (if any) the output of the code
     * throws an error if the code has a parsing error.
     */
    public function __construct(string $code)
    {
        $this->code = $code;
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
        $input = $this->prepareCode();

        if (!is_null($code)) {
            $input .= $code;
        }

        return $this->doEval($input);
    }

    public function doEval(string $code)
    {
        ob_start();
        try {
            $result = eval($code);
            $output = ob_get_clean();

            return array('result' => $result, 'output' => trim($output));
        }
        catch(\Error $e) {
            $output = ob_get_clean();
            return array('error' => $e->getMessage() . ' at line ' . $e->getLine(), 'output' => trim($output));
        }
    }

    public function prepareCode(): string
    {
        $input = preg_replace("/^\<\?php/", '', $this->code);
        $input = preg_replace("/\?\>$/", '', $input);

        return $input;
    }
}
