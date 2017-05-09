<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Pow;

class PowRuleTest extends TestCase
{
    public function testInstance()
    {
        $Pow = new Pow(array(), true);

        $this->assertInstanceOf(Pow::class, $Pow, "\$Pow is an instance of the Pow class");
    }

    public function testGetRule()
    {
        $Pow = new Pow(array(), true);

        $this->assertInternalType('callable', $Pow->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $PowNode = new \PhpParser\Node\Expr\BinaryOp\Pow($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Pow = new Pow(array(), true);
        $rule = $Pow->getRule();
        $this->assertEquals(true, $rule($PowNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Pow = new Pow(array('unknown' => 'name'), true);
    }
}
