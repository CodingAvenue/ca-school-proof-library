<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Identical;

class IdenticalRuleTest extends TestCase
{
    public function testInstance()
    {
        $identical = new Identical(array(), true);

        $this->assertInstanceOf(Identical::class, $identical, "\$identical is an instance of the Identical class");
    }

    public function testGetRule()
    {
        $identical = new Identical(array(), true);

        $this->assertInternalType('callable', $identical->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $identicalNode = new \PhpParser\Node\Expr\BinaryOp\Identical($left, $right, array('startLine' => 1, 'endLine' => 1));

        $identical = new Identical(array(), true);
        $rule = $identical->getRule();
        $this->assertEquals(true, $rule($identicalNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $identical = new Identical(array('unknown' => 'name'), true);
    }
}
