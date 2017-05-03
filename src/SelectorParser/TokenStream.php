<?php

namespace CodingAvenue\Proof\SelectorParser;

use CodingAvenue\Proof\SelectorParser\Token;

class TokenStream
{
    /** @var array $tokens array of tokens that this stream is handling */
    private $tokens = array();

    /** @var int $cursor the stream cursor */
    private $cursor = 0;

    public function push(string $type, string $value)
    {
        $this->tokens[] = new Token($type, $value);
    }

    // I don't think this method name is accurate, it's returning the current token and MOVE the cursor pointer
    public function getNextToken()
    {
        if ($this->hasTokens() && $this->cursor < $this->getLength()) {
            return $this->tokens[$this->cursor++];
        }

        return null;
    }

    public function peekNextToken()
    {
        if ($this->hasTokens() && $this->cursor + 1 < $this->getLength()) {
            return $this->tokens[$this->cursor + 1];
        }

        return null;
    }

    public function peekPreviousToken()
    {
        if (!$this->hasToken() || $this->cursor === 0) {
            return null;
        }

        return $this->tokens[$this->cursor - 1];
    }

    public function getCurrentToken()
    {
        if (!$this->hasTokens()) {
            return null;
        }

        return $this->tokens[$this->cursor];
    }

    public function getCursor()
    {
        return $this->cursor;
    }

    public function getLength()
    {
        return count($this->tokens);
    }

    public function hasTokens()
    {
        return $this->getLength() !== 0;
    }

    public function getRemainingLength()
    {
        return $this->getLength() - ($this->cursor);
    }

    public function isEnd()
    {
        return $this->getRemainingLength() === 0;
    }

    public function skipWhiteSpaceTokens()
    {
        while ($this->getRemainingLength() !== 0) {
            $token = $this->peekNextToken();
            if ($token->getType() === 'whitespace') {
                $this->getNextToken();
                continue;
            }

            break;
        }
    }
}
