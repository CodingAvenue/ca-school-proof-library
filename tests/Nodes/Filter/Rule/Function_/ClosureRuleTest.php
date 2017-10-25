<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Closure;

class ClosureRuleTest extends TestCase
{
    public function testInstance()
    {
        $anon = new Closure(array(), true);

        $this->assertInstanceOf(Closure::Class, $anon, "\$anon is an instance of the Closure class");
    }

    public function testGetRule()
    {
        $anon = new Closure(array(), true);

        $this->assertInternalType('callable', $anon->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $anonNode = new PhpParser\Node\Expr\Closure(array(), array());

        $anon = new Closure(array(), true);
        $rule = $anon->getRule();
        $this->assertEquals(true, $rule($anonNode), "The callback returns true closure nodes");

        $variable = new PhpParser\Node\Expr\Variable('var', array());
        $this->assertEquals(false, $rule($variable), "The callback returns false on variable nodes");
    }
}