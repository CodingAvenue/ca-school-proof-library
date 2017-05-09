<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseOr;

class BitwiseOrRuleTest extends TestCase
{
    public function testInstance()
    {
        $BitwiseOr = new BitwiseOr(array(), true);

        $this->assertInstanceOf(BitwiseOr::class, $BitwiseOr, "\$BitwiseOr is an instance of the BitwiseOr class");
    }

    public function testGetRule()
    {
        $BitwiseOr = new BitwiseOr(array(), true);

        $this->assertInternalType('callable', $BitwiseOr->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\BitwiseOr($left, $right, array('startLine' => 1, 'endLine' => 1));

        $BitwiseOr = new BitwiseOr(array(), true);
        $rule = $BitwiseOr->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $BitwiseOr = new BitwiseOr(array('unknown' => 'name'), true);
    }
}
