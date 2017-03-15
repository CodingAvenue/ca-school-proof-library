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
