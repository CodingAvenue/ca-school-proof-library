<?php

namespace CodingAvenue\Proof;

class Evaluator
{
    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function evaluate(): array
    {
        $input = $this->prepareCode();

        ob_start();
        $result = eval($input);
        $output = ob_get_clean();

        return [ result => $result, output => trim($output) ];
    }

    public function prepareCode(): string
    {
        $input = preg_replace("/^\<\?php/", '', $this->code);
        $input = preg_replace("/\?\>$/", '', $input);

        return $input;
    }
}
