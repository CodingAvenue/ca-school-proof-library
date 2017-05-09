<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\AssignConcat;

class AssignConcatRuleTest extends TestCase
{
    public function testInstance()
    {
        $assignConcat = new AssignConcat(array(), true);

        $this->assertInstanceOf(AssignConcat::class, $assignConcat, "\$assignConcat is an instance of the AssignConcat class");
    }

    public function testGetRule()
    {
        $assignConcat = new AssignConcat(array(), true);

        $this->assertInternalType('callable', $assignConcat->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $var = new \PhpParser\Node\Expr\Variable('name', array('startLine' => 1, 'endLine' => 1));
        $expr = new \PhpParser\Node\Scalar\String_('test ', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));
        $assignConcatNode = new \PhpParser\Node\Expr\AssignOP\Concat($var, $expr, array('startLine' => 1, 'endLine' => 1));

        $assignConcat = new AssignConcat(array(), true);
        $rule = $assignConcat->getRule();
        $this->assertEquals(true, $rule($assignConcatNode), "The callback returns true");

        $assignConcat = new AssignConcat(array('variable' => 'name'), true);
        $rule = $assignConcat->getRule();
        $this->assertEquals(true, $rule($assignConcatNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $assignConcat = new AssignConcat(array('unknown' => 'name'), true);
    }
}
