<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Pow;

class AssignPowRuleTest extends TestCase
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
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignPow = new \PhpParser\Node\Expr\AssignOp\Pow($variable, $nextValue);

        $Pow = new Pow(array(), true);
        $rule = $Pow->getRule();
        $this->assertEquals(true, $rule($assignPow), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Pow = new Pow(array('unknown' => 'name'), true);
    }
}
