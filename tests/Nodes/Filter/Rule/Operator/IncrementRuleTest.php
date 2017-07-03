<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Increment;

class IncrementRuleTest extends TestCase
{
    public function testInstance()
    {
        $increment = new Increment(array(), true);
        $this->assertInstanceOf(Increment::class, $increment, "\$increment is an instance of the Increment class");
    }

    public function testGetRule()
    {
        $increment = new Increment(array(), true);

        $this->assertInternalType('callable', $increment->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('aNumber', array('startLine' => 1, 'endLine' => 1));
        $incrementNode = new \PhpParser\Node\Expr\PostInc($variable, array('startLine' => 1, 'endLine' => 1));

        $increment = new Increment(array(), true);
        $rule = $increment->getRule();
        $this->assertEquals(true, $rule($incrementNode), "The callback returns true on nodes with increment");
        $this->assertEquals(false, $rule($variable), "The callback returns false on non increment node");

        $incrementNode = new \PhpParser\Node\Expr\PreInc($variable, array('startLine' => 1, 'endLine' => 1));

        $increment = new Increment(array(), true);
        $rule = $increment->getRule();
        $this->assertEquals(true, $rule($incrementNode), "The callback returns true on nodes with increment");
        $this->assertEquals(false, $rule($variable), "The callback returns false on non increment node");

        $preIncrementNode = new \PhpParser\Node\Expr\PreInc($variable, array('startLine' => 1, 'endLine' => 1));

        $increment = new Increment(array('type' => 'pre'), true);
        $rule = $increment->getRule();
        $this->assertEquals(true, $rule($preIncrementNode), "The callback returns true on nodes with pre increment");

        $increment = new Increment(array('type' => 'post'), true);
        $rule = $increment->getRule();
        $this->assertEquals(false, $rule($preIncrementNode), "The callback returns false");

        $postIncrementNode = new \PhpParser\Node\Expr\PostInc($variable, array('startLine' => 1, 'endLine' => 1));

        $increment = new Increment(array('type' => 'post'), true);
        $rule = $increment->getRule();
        $this->assertEquals(true, $rule($postIncrementNode), "The callback returns true on nodes with post increment");

        $increment = new Increment(array('type' => 'pre'), true);
        $rule = $increment->getRule();
        $this->assertEquals(false, $rule($postIncrementNode), "The callback returns false");        
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $increment = new Increment(array('unknown' => 'name'), true);
    }
}