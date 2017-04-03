<?php

namespace CodingAvenue\Proof\Code\Nodes;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;

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

    public function readNext()
    {
        $filter = array(null, [], null, $this->previousIsWhiteSpace() ? false : true);

        while (true) {
            $token = $this->stream->getNext();
            $this->read[] = $token;

            if (is_null($token) || $token->isWhiteSpace()) {
                break;
            }

            if ($token->isNode()) {
                $filter[0] = $this->readToken($token);
                continue;
            }
            elseif ($token->isAttr()) {
                $filter[1] = $this->readToken($token);
                continue;
            }
            elseif ($token->isPseudo()) {
                $filter[2] = $this->readToken($token);
                continue;
            }
            elseif ($token->isOperator()) {
                $filter[3] = true;
                continue;
            }
            
            break;
        }
        
        return $filter;
    }

    public function readToken(Token $token)
    {
        $filter = [];
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
