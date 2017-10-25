<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanAnd;

class BooleanAndRuleTest extends TestCase
{
    public function testInstance()
    {
        $booleanAnd = new BooleanAnd(array(), true);

        $this->assertInstanceOf(BooleanAnd::class, $booleanAnd, "\$booleanAnd is an instance of the BooleanAnd class");
    }

    public function testGetRule()
    {
        $booleanAnd = new BooleanAnd(array(), true);

        $this->assertInternalType('callable', $booleanAnd->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $booleanAndNode = new \PhpParser\Node\Expr\BinaryOp\BooleanAnd($left, $right, array('startLine' => 1, 'endLine' => 1));

        $booleanAnd = new BooleanAnd(array(), true);
        $rule = $booleanAnd->getRule();
        $this->assertEquals(true, $rule($booleanAndNode), "The callback returns true");
        $this->assertEquals(false, $rule($left), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $booleanAnd = new BooleanAnd(array('unknown' => 'name'), true);
    }
}
