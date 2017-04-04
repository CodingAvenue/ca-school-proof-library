<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Reader;

interface HandlerInterface
{
    /**
     * parse the Reader's source from the reader's current position.
     * creates a new token and push it to the TokenStream if it can handle the source.
     * 
     * @param Reader the reader instance
     * @param TokenStream the token stream instance
     *
     * @return bool true if it can handle the reader's current position false otherwise.
     */
    public function handle(Reader $reader, TokenStream $stream);
}