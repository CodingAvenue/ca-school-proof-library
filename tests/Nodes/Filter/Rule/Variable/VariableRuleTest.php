<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Variable;

class VariableRuleTest extends TestCase
{
    public function testInstance()
    {
        $variable = new Variable(array(), true);

        $this->assertInstanceOf(Variable::class, $variable, "\$variable is an instance of the Variable class");

        $variable = new Variable(array('name' => 'test'), true);

        $this->assertInstanceOf(Variable::class, $variable, "\$variable is an instance of the Variable class");
    }

    public function testGetRule()
    {
        $variable = new Variable(array(), true);

        $this->assertInternalType('callable', $variable->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $node = new \PhpParser\Node\Expr\Variable('var', array('startLine' => 1, 'endLine' => 1));

        $variable = new Variable(array(), true);
        $node = new \PhpParser\Node\Expr\Variable('var', array('startLine' => 1, 'endLine' => 1));
        $rule = $variable->getRule();
        $this->assertEquals(true, $rule($node), "The callback returns true");

        $variable = new Variable(array('name' => 'var'), true);
        $rule = $variable->getRule();
        $this->assertEquals(true, $rule($node), "The callback returns true");

        $variable = new Variable(array('name' => 'vars'), true);
        $rule = $variable->getRule();
        $this->assertEquals(false, $rule($node), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $variable = new Variable(array('unknown' => true), true);
    }
}
