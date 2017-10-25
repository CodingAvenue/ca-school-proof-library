<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Foreach_;

class ForeachRuleTest extends TestCase
{
    public function testInstance()
    {
        $Foreach = new Foreach_(array(), true);

        $this->assertInstanceOf(Foreach_::class, $Foreach, "\$Foreach is an instance of the Foreach_ class");
    }

    public function testGetRule()
    {
        $Foreach = new Foreach_(array(), true);

        $this->assertInternalType('callable', $Foreach->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $array = new PhpParser\Node\Expr\Array_(array());
        $var = new PhpParser\Node\Expr\Variable('name');
        $ForeachNode = new PhpParser\Node\Stmt\Foreach_($array, $var, array(), array('startLine' => 1, 'endLine' => 1));

        $Foreach = new Foreach_(array(), true);
        $rule = $Foreach->getRule();

        $this->assertEquals(true, $rule($ForeachNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Foreach = new Foreach_(array('unknown' => 'name'), true);
    }
}
