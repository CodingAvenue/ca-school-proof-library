<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Else_;

class ElseRuleTest extends TestCase
{
    public function testInstance()
    {
        $else = new Else_(array(), true);

        $this->assertInstanceOf(Else_::class, $else, "\$else is an instance of the Else_ class");
    }

    public function testGetRule()
    {
        $else = new Else_(array(), true);

        $this->assertInternalType('callable', $else->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $elseNode = new PhpParser\Node\Stmt\Else_(array(), array('startLine' => 1, 'endLine' => 1));

        $else = new Else_(array(), true);
        $rule = $else->getRule();

        $this->assertEquals(true, $rule($elseNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $else = new Else_(array('unknown' => 'name'), true);
    }
}
