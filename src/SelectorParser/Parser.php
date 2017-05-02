<?php

namespace CodingAvenue\Proof\SelectorParser;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Handler\HandlerInterface;
use CodingAvenue\Proof\SelectorParser\Handler\ColonHandler;
use CodingAvenue\Proof\SelectorParser\Handler\SpaceHandler;
use CodingAvenue\Proof\SelectorParser\Handler\OpenSquareBracketHandler;
use CodingAvenue\Proof\SelectorParser\Handler\CloseSquareBracketHandler;
use CodingAvenue\Proof\SelectorParser\Handler\QuoteHandler;
use CodingAvenue\Proof\SelectorParser\Handler\EqualHandler;
use CodingAvenue\Proof\SelectorParser\Handler\CommaHandler;
use CodingAvenue\Proof\SelectorParser\Handler\StringHandler;

/**
 * SelectParser - Tokenizer of a selector string
 */
class Parser
{
    /** @var string $source The source string to be parse */
    private $source;

    /** @var array() $handlers The handlers for this parser */
    private $handlers;

    public function __construct(string $source)
    {
        $this->source = $source;
        $this->loadDefaultHandlers();
    }

    public function loadDefaultHandlers()
    {
        $this
            /**->addHandler(new ColonHandler()) */
            ->addHandler(new SpaceHandler())
            ->addHandler(new OpenSquareBracketHandler())
            ->addHandler(new CloseSquareBracketHandler())
            ->addHandler(new QuoteHandler())
            ->addHandler(new EqualHandler())
            ->addHandler(new CommaHandler())
            ->addHandler(new StringHandler());
    }

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * Main parse method. Parses the selector, create a Token on each character and push it to the TokenStream
     *
     * @return TokenStream instance.
     */
    public function parse(): TokenStream
    {
        $reader = new SourceReader($this->source);
        $stream = new TokenStream();

        while (!$reader->isEnd()) {
            foreach ($this->handlers as $handler) {
                if ($handler->handle($reader, $stream)) {
                    continue 2;
                }
            }

            throw new \Exception("Cannot find any handler to handle this character {$reader->getCurrentChar()}");
        }

        return $stream;
    }
}
