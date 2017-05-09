<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\Concat;

class ConcatRuleTest extends TestCase
{
    public function testInstance()
    {
        $concat = new Concat(array(), true);

        $this->assertInstanceOf(Concat::class, $concat, "\$concat is an instance of the Concat class");
    }

    public function testGetRule()
    {
        $concat = new Concat(array(), true);

        $this->assertInternalType('callable', $concat->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\String_('test ', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));
        $right = new \PhpParser\Node\Scalar\String_('me ', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));
        $concatNode = new \PhpParser\Node\Expr\BinaryOP\Concat($left, $right, array('startLine' => 1, 'endLine' => 1));

        $concat = new Concat(array(), true);
        $rule = $concat->getRule();
        $this->assertEquals(true, $rule($concatNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $assignment = new Concat(array('unknown' => 'name'), true);
    }
}
