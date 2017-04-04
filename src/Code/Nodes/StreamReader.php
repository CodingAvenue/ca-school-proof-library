<?php

namespace CodingAvenue\Proof\Code\Nodes;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\NodesFilter;

class StreamReader
{
    private $stream;
    private $read = array();

    // This list might grow more.
    private $nodeNames = array('function', 'operator', 'construct', 'variable', 'class', 'builtin', 'interpolation');

    public function __construct(TokenStream $stream)
    {
        $this->stream = $stream;
    }

    public function readNext(): NodesFilter
    {
        $nodeFilter = new NodesFilter($this->previousIsWhiteSpace() ? false : true);

        while (true) {
            $token = $this->stream->getNext();
            $this->read[] = $token;

            if (is_null($token) || $token->isWhiteSpace()) {
                break;
            }

            if ($token->isNode()) {
                $nodeFilter->setAction($this->readToken($token));
                continue;
            }
            elseif ($token->isAttr()) {
                $nodeFilter->setParams($this->readToken($token));
                continue;
            }
            elseif ($token->isPseudo()) {
                $nodeFilter->setPseudo($this->readToken($token));
                continue;
            }
            elseif ($token->isOperator()) {
                $nodeFilter->setTraverseChildren(true);
                continue;
            }
            
            break;
        }
        
        return $nodeFilter;
    }

    public function readToken(Token $token)
    {
        if ($token->isNode()) {
            if (in_array($token->getValue(), $this->nodeNames)) {
                return ucwords($token->getValue());
            }
            else {
                return 'EncapsedString';
            }
        }
        elseif ($token->isAttr()) {
            return $token->getValue();
        }
        elseif ($token->isPseudo()) {
            return $token->getValue();
        }

        throw new \Exception("Unexpected Token found");
    }

    public function hasUnread()
    {
        return count($this->read) < $this->stream->getLength();
    }

    public function getReadCount()
    {
        return count($this->read);
    }

    public function previousIsWhiteSpace()
    {
        if ($this->getReadCount() != 0) {
            $token = $this->read[$this->getReadCount() - 1];
            $token->isWhiteSpace() ? true : false;
        }

        return false;
    }
}
