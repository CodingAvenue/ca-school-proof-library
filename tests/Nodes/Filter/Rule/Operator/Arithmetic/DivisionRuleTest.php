<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Division;

class DivisionRuleTest extends TestCase
{
    public function testInstance()
    {
        $Division = new Division(array(), true);

        $this->assertInstanceOf(Division::class, $Division, "\$Division is an instance of the Division class");
    }

    public function testGetRule()
    {
        $Division = new Division(array(), true);

        $this->assertInternalType('callable', $Division->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $DivisionNode = new \PhpParser\Node\Expr\BinaryOp\Div($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Division = new Division(array(), true);
        $rule = $Division->getRule();
        $this->assertEquals(true, $rule($DivisionNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Division = new Division(array('unknown' => 'name'), true);
    }
}
