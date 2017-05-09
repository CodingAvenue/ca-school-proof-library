<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Addition;

class AdditionRuleTest extends TestCase
{
    public function testInstance()
    {
        $Addition = new Addition(array(), true);

        $this->assertInstanceOf(Addition::class, $Addition, "\$Addition is an instance of the Addition class");
    }

    public function testGetRule()
    {
        $Addition = new Addition(array(), true);

        $this->assertInternalType('callable', $Addition->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $AdditionNode = new \PhpParser\Node\Expr\BinaryOp\Plus($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Addition = new Addition(array(), true);
        $rule = $Addition->getRule();
        $this->assertEquals(true, $rule($AdditionNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Addition = new Addition(array('unknown' => 'name'), true);
    }
}
