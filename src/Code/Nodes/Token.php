<?php

namespace CodingAvenue\Proof\Code\Nodes;

class Token
{
    /** @const a token type for nodes */
    const TYPE_NODE = 'node';
    /** @const a token type for attr */
    const TYPE_ATTR = 'attr';
    /** @const a token type for pseudo class */
    const TYPE_PSEUDO = 'pseudo';
    /** @const a token type for whitespace */
    const TYPE_WHITESPACE = 'whitespace';
    /** @const a token type for operator */
    const TYPE_OPERATOR = 'operator';

    /** @var string any of the const value */
    private $type;
    /** @var value the value of the token */
    private $value;
    
    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isNode()
    {
        return self::TYPE_NODE === $this->type;
    }

    public function isAttr()
    {
        return self::TYPE_ATTR === $this->type;
    }

    public function isPseudo()
    {
        return self::TYPE_PSEUDO === $this->type;
    }

    public function isWhiteSpace()
    {
        return self::TYPE_WHITESPACE === $this->type;
    }

    public function isOperator()
    {
        return self::TYPE_OPERATOR === $this->type;
    }
}
