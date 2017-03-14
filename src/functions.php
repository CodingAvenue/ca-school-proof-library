<?php

namespace CodingAvenue\Proof;

use PhpParser\Node\Expr\{
    Assign,
    Variable
};

use PhpParser\Node\Scalar;


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

    $command = "phpcs -q --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 --report=json --standard=PSR2 $file";

    exec($command, $output, $exitCode);

    if ($exitCode !== 0 ) {
        throw new \Exception($output[0]);
    }

    return json_decode($output[0]);
}
