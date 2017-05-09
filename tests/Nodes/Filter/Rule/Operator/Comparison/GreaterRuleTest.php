<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Greater;

class GreaterRuleTest extends TestCase
{
    public function testInstance()
    {
        $greater = new Greater(array(), true);

        $this->assertInstanceOf(Greater::class, $greater, "\$greater is an instance of the Greater class");
    }

    public function testGetRule()
    {
        $greater = new Greater(array(), true);

        $this->assertInternalType('callable', $greater->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $greaterNode = new \PhpParser\Node\Expr\BinaryOp\Greater($left, $right, array('startLine' => 1, 'endLine' => 1));

        $greater = new Greater(array(), true);
        $rule = $greater->getRule();
        $this->assertEquals(true, $rule($greaterNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $greater = new Greater(array('unknown' => 'name'), true);
    }
}
