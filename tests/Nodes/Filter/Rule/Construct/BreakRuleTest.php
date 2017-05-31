<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Break_;

class BreakRuleTest extends TestCase
{
    public function testInstance()
    {
        $break = new Break_(array(), true);

        $this->assertInstanceOf(Break_::class, $break, "\$case is an instance of the Break_ class");
    }

    public function testGetRule()
    {
        $break = new Break_(array(), true);

        $this->assertInternalType('callable', $break->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $breakNode = new PhpParser\Node\Stmt\Break_(null, array('startLine' => 1, 'endLine' => 1));

        $break = new Break_(array(), true);
        $rule = $break->getRule();

        $this->assertEquals(true, $rule($breakNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $breakNode = new PhpParser\Node\Stmt\Break_($valueNode, array('startLine' => 1, 'endLine' => 1));

        $break = new Break_(array(), true);
        $rule = $break->getRule();

        $this->assertEquals(true, $rule($breakNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $break = new Break_(array('hasArg' => 'true'), true);
        $rule = $break->getRule();

        $this->assertEquals(true, $rule($breakNode), "The callback returns true");

        $break = new Break_(array('hasArg' => 'false'), true);
        $rule = $break->getRule();

        $this->assertEquals(false, $rule($breakNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $break = new Break_(array('unknown' => 'name'), true);
    }
}
