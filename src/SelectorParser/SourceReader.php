<?php

namespace CodingAvenue\Proof\SelectorParser;

/**
 * The SelectorParser reader class. Reading one character at a time.
 */
class SourceReader
{
    /** @var string $source The selector string */
    private $source;

    /** @var int $length The length of the source */
    private $length;

    /** @var int $position The current position of the reader from the source */
    private $position = 0;

    public function __construct(string $source)
    {
        $this->source = $source;
        $this->length = strlen($source);
    }

    /**
     * Checks if the current position is at the end of the source
     *
     * @return bool true if the position is at the end of the source, false otherwise
     */
    public function isEnd()
    {
        return $this->position >= $this->length;
    }

    /**
     * Get's the character from the source based on the position value.
     *
     * @return char 
     */
    public function getCurrentChar()
    {
        return substr($this->source, $this->position, 1);
    }

    public function movePosition(int $length)
    {
        if ($this->getRemainingLength() < $length) {
            throw new \Exception("Position is outside the length of the source.");
        }

        $this->position += $length;
    }

    /**
     * @return int the remaining characters from the current position of the reader.
     */
    public function getRemainingLength()
    {
        return $this->length - $this->position;
    }

    public function isWhiteSpace()
    {
        $char = $this->getCurrentChar();
        return ($char == ' ' || $char == '\t' || $char == '\n' || $char == '\r');
    }

    public function getPosition()
    {
        return $this->postion;
    }

    public function getLength()
    {
        return $this->length;
    }
}
