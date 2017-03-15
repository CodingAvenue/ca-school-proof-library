<?php

namespace CodingAvenue\Proof;

use PhpParser\Node\Expr\{
    Assign,
    Variable
};

use PhpParser\Node\Scalar;
use CodingAvenue\VendorBin;


/**
 * @param array $parsed
 * @param string $name
 */
function findVariable(array $tokens, string $name): array
{
    $tokens = array_filter($tokens, function ($token) use ($name) {
        return ($token instanceof Assign && $token->var instanceof Variable && $token->var->name === $name);
    });

    $tokens = array_map(function ($token) {
        $value = ($token->expr instanceof Scalar)
            ? $token->expr->value
            : $token->expr;

        return ['variable' => $token->var->name, 'value' => $value];
    }, $tokens);

    return $tokens;
}

function psr2Check(string $file): array
{
    if (!file_exists($file)) {
        throw new \Exception("File $file not found");
    }

    $phpcs = VendorBin::getCS();
    $command = "$phpcs -q --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 --report=json --standard=PSR2 $file 2>&1";

    exec($command, $output, $exitCode);

    if ($exitCode !== 0 ) {
        throw new \Exception($output[0]);
    }

    $snifferOutput = json_decode($output[0], true);
    $csOutput = [
        'isPSR2Compliant' => true
    ];

    foreach ($snifferOutput['files'] as $file) {
        foreach ($file['messages'] as $message) {
            $csOutput['isPSR2Compliant'] = false;

            $csOutput['messages'][] = [
                'message'   => $message['message'],
                'line'      => $message['line'],
                'column'    => $message['column']
            ];
        }
    }

    return $csOutput;
}

function phpMDCheck(string $file): array
{
    if ( !file_exists($file)) {
        throw new \Exception("File $file not found");
    }

    $phpmd = VendorBin::getMD();
    $command = "$phpmd $file xml cleancode,codesize,controversial,design,naming,unusedcode --ignore-violations-on-exit 2>&1";

    exec($command, $output, $exitCode);

    if ($exitCode !== 0) {
        throw new \Exception($output[0]);
    }

    $xml = simplexml_load_string(implode("", $output));

    $mdOutput = [ 'hasMess' => false ];

    if ($xml->file) {
        foreach($xml->file->children() as $violation) {
            $mdOutput['hasMess'] = true;

            $mdOutput['violations'][] = [
                'violation' => $violation,
                'beginLine' => $violation['beginline'],
                'endLine'   => $violation['endline']
            ];
        }
    }

    return $mdOutput;
}
