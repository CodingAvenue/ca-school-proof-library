<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Less;

class LessRuleTest extends TestCase
{
    public function testInstance()
    {
        $less = new Less(array(), true);

        $this->assertInstanceOf(Less::class, $less, "\$less is an instance of the Less class");
    }

    public function testGetRule()
    {
        $less = new Less(array(), true);

        $this->assertInternalType('callable', $less->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $lessNode = new \PhpParser\Node\Expr\BinaryOp\Smaller($left, $right, array('startLine' => 1, 'endLine' => 1));

        $less = new Less(array(), true);
        $rule = $less->getRule();
        $this->assertEquals(true, $rule($lessNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $less = new Less(array('unknown' => 'name'), true);
    }
}
