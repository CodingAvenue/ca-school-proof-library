<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotIdentical;

class NotIdenticalRuleTest extends TestCase
{
    public function testInstance()
    {
        $NotIdentical = new NotIdentical(array(), true);

        $this->assertInstanceOf(NotIdentical::class, $NotIdentical, "\$NotIdentical is an instance of the NotIdentical class");
    }

    public function testGetRule()
    {
        $NotIdentical = new NotIdentical(array(), true);

        $this->assertInternalType('callable', $NotIdentical->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\NotIdentical($left, $right, array('startLine' => 1, 'endLine' => 1));

        $NotIdentical = new NotIdentical(array(), true);
        $rule = $NotIdentical->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $NotIdentical = new NotIdentical(array('unknown' => 'name'), true);
    }
}
