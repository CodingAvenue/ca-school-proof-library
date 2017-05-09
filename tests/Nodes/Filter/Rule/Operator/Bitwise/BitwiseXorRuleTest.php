<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseXor;

class BitwiseXorRuleTest extends TestCase
{
    public function testInstance()
    {
        $BitwiseXor = new BitwiseXor(array(), true);

        $this->assertInstanceOf(BitwiseXor::class, $BitwiseXor, "\$BitwiseXor is an instance of the BitwiseXor class");
    }

    public function testGetRule()
    {
        $BitwiseXor = new BitwiseXor(array(), true);

        $this->assertInternalType('callable', $BitwiseXor->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\BitwiseXor($left, $right, array('startLine' => 1, 'endLine' => 1));

        $BitwiseXor = new BitwiseXor(array(), true);
        $rule = $BitwiseXor->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $BitwiseXor = new BitwiseXor(array('unknown' => 'name'), true);
    }
}
