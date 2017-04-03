<?php

namespace CodingAvenue\Proof\Code\Nodes;

class Reader
{
    /** @var string the selector string */
    private $source;
    /** @var int the length of the source string */
    private $length;
    /** @var the position of the reader on the source. */
    private $position = 0;

    /**
     * The selector Reader class. Ideally reading 1 character from the source at a time.
     * Moving it's position to read the rest of the characters.
     */
    public function __construct($source)
    {
        $this->source = $source;
        $this->length = strlen($source);
    }

    /**
     * @return bool checks if the current position has reach the end of the source.
     */
    public function isEnd()
    {
        return $this->position >= $this->length;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return int the remaining characters from the current position of the reader.
     */
    public function getRemainingLength()
    {
        return $this->length - $this->position;
    }

    /**
     * @param int the number of characters to return.
     * @param int the offset from the current reader's position
     *
     * @return the characters from the current reader's position
     */
    public function getSubstr(int $length, $offset = 0)
    {
        return substr($this->source, $this->position + $offset, $length);
    }

    public function movePosition(int $length)
    {
        if ($this->getRemainingLength() < $length) {
            throw new \Exception("Position is outside the length of the source.");
        }

        $this->position += $length;
    }

    public function isWhiteSpace()
    {
        $char = $this->getSubstr(1);
        return ($char == ' ' || $char == '\t' || $char == '\n' || $char == '\r');
    }

    public function skipWhiteSpace()
    {
        while (!$this->isEnd() && $this->isWhiteSpace()) {
            $this->movePosition(1);
        }
    }
}
