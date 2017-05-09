<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseAnd;

class BitwiseAndRuleTest extends TestCase
{
    public function testInstance()
    {
        $BitwiseAnd = new BitwiseAnd(array(), true);

        $this->assertInstanceOf(BitwiseAnd::class, $BitwiseAnd, "\$BitwiseAnd is an instance of the BitwiseAnd class");
    }

    public function testGetRule()
    {
        $BitwiseAnd = new BitwiseAnd(array(), true);

        $this->assertInternalType('callable', $BitwiseAnd->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\BitwiseAnd($left, $right, array('startLine' => 1, 'endLine' => 1));

        $BitwiseAnd = new BitwiseAnd(array(), true);
        $rule = $BitwiseAnd->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $BitwiseAnd = new BitwiseAnd(array('unknown' => 'name'), true);
    }
}
