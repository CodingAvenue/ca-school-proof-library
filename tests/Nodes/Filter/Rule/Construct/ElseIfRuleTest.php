<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\ElseIf_;

class ElseIfRuleTest extends TestCase
{
    public function testInstance()
    {
        $elseif = new ElseIf_(array(), true);

        $this->assertInstanceOf(ElseIf_::class, $elseif, "\$else is an instance of the ElseIf_ class");
    }

    public function testGetRule()
    {
        $elseif = new ElseIf_(array(), true);

        $this->assertInternalType('callable', $elseif->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $elseifNode = new PhpParser\Node\Stmt\ElseIf_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $elseif = new ElseIf_(array(), true);
        $rule = $elseif->getRule();

        $this->assertEquals(true, $rule($elseifNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $elseif = new ElseIf_(array('unknown' => 'name'), true);
    }
}
