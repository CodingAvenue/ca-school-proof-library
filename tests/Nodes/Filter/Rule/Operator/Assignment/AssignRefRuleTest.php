<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment\AssignRef;

class AssignRefRuleTest extends TestCase
{
    public function testInstance()
    {
        $assignRef = new AssignRef(array(), true);

        $this->assertInstanceOf(AssignRef::class, $assignRef, "\$assignRef is an instance of the AssignRef class");
    }

    public function testGetRule()
    {
        $assignRef = new AssignRef(array(), true);

        $this->assertInternalType('callable', $assignRef->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('name', array('startLine' => 1, 'endLine' => 1));
        $variableRef = new \PhpParser\Node\Expr\Variable('nameRef', array('startLine' => 1, 'endLine' => 1));
        $exp = new \PhpParser\Node\Scalar\String_('foo', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));
        $assignmentNode = new \PhpParser\Node\Expr\Assign($variable, $exp, array('startLine' => 1, 'endLine' => 1));
        $assignmentRef = new \PhpParser\Node\Expr\AssignRef($variableRef, $variable, array('startLine' => 1, 'endLine' => 1));

        $assignRef = new AssignRef(array(), true);
        $rule = $assignRef->getRule();
        $this->assertEquals(true, $rule($assignmentRef), "The callback returns true");

        $assignRef = new AssignRef(array('variable' => 'nameRef'), true);
        $rule = $assignRef->getRule();
        $this->assertEquals(true, $rule($assignmentRef), "The callback returns true");

        $assignRef = new AssignRef(array('variable-ref' => 'name'), true);
        $rule = $assignRef->getRule();
        $this->assertEquals(true, $rule($assignmentRef), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $assignRef = new AssignRef(array('unknown' => 'name'), true);
    }
}
