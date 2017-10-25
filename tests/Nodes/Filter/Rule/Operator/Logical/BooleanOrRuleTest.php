<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanOr;

class BooleanOrRuleTest extends TestCase
{
    public function testInstance()
    {
        $booleanOr = new BooleanOr(array(), true);

        $this->assertInstanceOf(BooleanOr::class, $booleanOr, "\$booleanOr is an instance of the BooleanOr class");
    }

    public function testGetRule()
    {
        $booleanOr = new BooleanOr(array(), true);

        $this->assertInternalType('callable', $booleanOr->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $booleanOrNode = new \PhpParser\Node\Expr\BinaryOp\BooleanOr($left, $right, array('startLine' => 1, 'endLine' => 1));

        $booleanOr = new BooleanOr(array(), true);
        $rule = $booleanOr->getRule();
        $this->assertEquals(true, $rule($booleanOrNode), "The callback returns true");
        $this->assertEquals(false, $rule($left), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $booleanOr = new BooleanOr(array('unknown' => 'name'), true);
    }
}
