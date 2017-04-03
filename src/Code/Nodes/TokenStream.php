<?php

namespace CodingAvenue\Proof\Code\Nodes;

class TokenStream
{
    /** @var array of tokens */
    private $tokens = array();
    /** @var int the current cursor of the stream */
    private $cursor = 0;
    /** @var bool if the strea mis currently on peeking mode */
    private $isPeeking = false;

    /**
     * returns the next token from the tokens properties. Will affect the cursor of the stream.
     *
     * @return a Token instance or null if the cursor is beyond the length of the tokens property.
     */
    public function getNext()
    {
        if ($this->getLength() > 0 && $this->cursor < $this->getLength()) {
            return $this->tokens[$this->cursor++];
        }

        return null;
    }

    /**
     * adds a token to this stream
     *
     * @param Token 
     */
    public function push(Token $token)
    {
        $this->tokens[] = $token;
    }

    public function getLength()
    {
        return count($this->tokens);
    }

    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * Gets the next Token without affecting the cursor.
     *
     * @return Token or null the next Token on the stream.
     */
    public function peekNextToken()
    {
        if (count($this->cursor) + 1 > $this->getLength()) {
            return null;
        }

        return $this->tokens[$this->cursor + 1];
    }

    /**
     * Gets the previous Token without affecting the cursor.
     *
     * @return Token or null the previous Token on the stream.
     */
    public function peekPreviousToken()
    {
        if ($this->getLength() == 0) {
            return null;
        }

        return $this->tokens[$this->getLength() - 1];
    }
}
