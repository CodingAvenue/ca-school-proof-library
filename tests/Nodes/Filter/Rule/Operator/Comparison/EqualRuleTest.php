<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Equal;

class EqualRuleTest extends TestCase
{
    public function testInstance()
    {
        $equal = new Equal(array(), true);

        $this->assertInstanceOf(Equal::class, $equal, "\$equal is an instance of the Equal class");
    }

    public function testGetRule()
    {
        $equal = new Equal(array(), true);

        $this->assertInternalType('callable', $equal->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $equalNode = new \PhpParser\Node\Expr\BinaryOp\Equal($left, $right, array('startLine' => 1, 'endLine' => 1));

        $equal = new Equal(array(), true);
        $rule = $equal->getRule();
        $this->assertEquals(true, $rule($equalNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $equal = new Equal(array('unknown' => 'name'), true);
    }
}
