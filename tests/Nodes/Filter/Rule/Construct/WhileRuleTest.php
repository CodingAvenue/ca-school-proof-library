<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\While_;

class WhileRuleTest extends TestCase
{
    public function testInstance()
    {
        $while = new While_(array(), true);

        $this->assertInstanceOf(While_::class, $while, "\$while is an instance of the While_ class");
    }

    public function testGetRule()
    {
        $while = new While_(array(), true);

        $this->assertInternalType('callable', $while->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $whileNode = new PhpParser\Node\Stmt\While_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $while = new While_(array(), true);
        $rule = $while->getRule();

        $this->assertEquals(true, $rule($whileNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $while = new While_(array('unknown' => 'name'), true);
    }
}
