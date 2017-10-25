<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Decrement;

class DecrementRuleTest extends TestCase
{
    public function testInstance()
    {
        $decrement = new Decrement(array(), true);
        $this->assertInstanceOf(Decrement::class, $decrement, "\$decrement is an instance of the Decrement class");
    }

    public function testGetRule()
    {
        $decrement = new Decrement(array(), true);

        $this->assertInternalType('callable', $decrement->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('aNumber', array('startLine' => 1, 'endLine' => 1));
        $decrementNode = new \PhpParser\Node\Expr\PostDec($variable, array('startLine' => 1, 'endLine' => 1));

        $decrement = new Decrement(array(), true);
        $rule = $decrement->getRule();
        $this->assertEquals(true, $rule($decrementNode), "The callback returns true on nodes with decrement");
        $this->assertEquals(false, $rule($variable), "The callback returns false on non decrement node");

        $decrementNode = new \PhpParser\Node\Expr\PreDec($variable, array('startLine' => 1, 'endLine' => 1));

        $decrement = new Decrement(array(), true);
        $rule = $decrement->getRule();
        $this->assertEquals(true, $rule($decrementNode), "The callback returns true on nodes with decrement");
        $this->assertEquals(false, $rule($variable), "The callback returns false on non decrement node");

        $preDecrementNode = new \PhpParser\Node\Expr\PreDec($variable, array('startLine' => 1, 'endLine' => 1));

        $decrement = new Decrement(array('type' => 'pre'), true);
        $rule = $decrement->getRule();
        $this->assertEquals(true, $rule($preDecrementNode), "The callback returns true on nodes with pre decrement");

        $decrement = new Decrement(array('type' => 'post'), true);
        $rule = $decrement->getRule();
        $this->assertEquals(false, $rule($preDecrementNode), "The callback returns false");

        $postDecrementNode = new \PhpParser\Node\Expr\PostDec($variable, array('startLine' => 1, 'endLine' => 1));

        $decrement = new Decrement(array('type' => 'post'), true);
        $rule = $decrement->getRule();
        $this->assertEquals(true, $rule($postDecrementNode), "The callback returns true on nodes with post decrement");

        $decrement = new Decrement(array('type' => 'pre'), true);
        $rule = $decrement->getRule();
        $this->assertEquals(false, $rule($postDecrementNode), "The callback returns false");        
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $decrement = new Decrement(array('unknown' => 'name'), true);
    }
}