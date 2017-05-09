<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment;

class AssignmentRuleTest extends TestCase
{
    public function testInstance()
    {
        $assignment = new Assignment(array(), true);

        $this->assertInstanceOf(Assignment::class, $assignment, "\$assignment is an instance of the Assignment class");
    }

    public function testGetRule()
    {
        $assignment = new Assignment(array(), true);

        $this->assertInternalType('callable', $assignment->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('name', array('startLine' => 1, 'endLine' => 1));
        $exp = new \PhpParser\Node\Scalar\String_('foo', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));
        $assignmentNode = new \PhpParser\Node\expr\Assign($variable, $exp, array('startLine' => 1, 'endLine' => 1));

        $assignment = new Assignment(array(), true);
        $rule = $assignment->getRule();
        $this->assertEquals(true, $rule($assignmentNode), "The callback returns true");

        $assignment = new Assignment(array('variable' => 'name'), true);
        $rule = $assignment->getRule();
        $this->assertEquals(true, $rule($assignmentNode), "The callback returns true");

        $assignment = new Assignment(array('variable' => 'foo'), true);
        $rule = $assignment->getRule();
        $this->assertEquals(false, $rule($assignmentNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $assignment = new Assignment(array('unknown' => 'name'), true);
    }
}
