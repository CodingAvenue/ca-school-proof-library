<?php

namespace CodingAvenue\Proof\Code\Nodes;

use CodingAvenue\Proof\Code\Nodes\Reader;
use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Handler\HandlerInterface;
use CodingAvenue\Proof\Code\Nodes\Handler\NodeHandler;
use CodingAvenue\Proof\Code\Nodes\Handler\AttrHandler;
use CodingAvenue\Proof\Code\Nodes\Handler\PseudoClassHandler;
use CodingAvenue\Proof\Code\Nodes\Handler\WhiteSpaceHandler;
use CodingAvenue\Proof\Code\Nodes\Handler\OperatorHandler;

class SelectorParser
{
    /** @var string The source to be parsed */
    private $source;
    /** @var array Array of handlers to parse the source */
    private $handlers = array();

    /**
     * Parse a selector string into a series of Tokens and push it into the TokenStream.
     */
    public function __construct(string $source)
    {
        $this->source = $source;
        $this
            ->addHandler(new NodeHandler())
            ->addHandler(new AttrHandler())
            ->addHandler(new PseudoClassHandler())
            ->addHandler(new WhiteSpaceHandler())
            ->addHandler(new OperatorHandler());
    }

    /**
     * Add's a handler to the handlers property. 
     * @param HandlerInterface
     *
     * @return The parser instance itself for cascading calling.
     */
    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * parse the source string into a series of tokens and push it into the TokenStream.
     * @return TokenStream instance.
     */
    public function parse(): TokenStream
    {
        $reader = new Reader($this->source);
        $stream = new TokenStream();

        while (!$reader->isEnd()) {
            foreach ($this->handlers as $handler) {
                if ($handler->handle($reader, $stream)) {
                    continue 2;
                }
            }

            // this shouldn't happen, but if we reach here, then there is a character on the selector that we cannot parse.
            throw new \Exception("Unable to find a handler to parse this selector starting at " . $reader->getSubstr($reader->getRemainingLength()));
        }

        return $stream;
    }
}
