<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Interpolation;

class InterpolationRuleTest extends TestCase
{
    public function testInstance()
    {
        $interpolation = new Interpolation(array(), true);

        $this->assertInstanceOf(Interpolation::class, $interpolation, "\$interpolation is an instance of the Variable class");
    }

    public function testGetRule()
    {
        $interpolation = new Interpolation(array(), true);

        $this->assertInternalType('callable', $interpolation->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $encapsedString = new \PhpParser\Node\Scalar\EncapsedStringPart('hi', array('startLine' => 1, 'endLine' => 1));
        $variable = new \PhpParser\Node\Expr\Variable('var', array('startLine' => 1, 'endLine' => 1));
        $node = new \PhpParser\Node\Scalar\Encapsed(array($encapsedString, $variable), array('startLine' => 1, 'endLine' => 1, 'kind' => 2));

        $interpolation = new Interpolation(array(), true);
        $rule = $interpolation->getRule();
        $this->assertEquals(true, $rule($node), "The callback returns true");

        $this->assertEquals(false, $rule($variable), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $interpolation = new Interpolation(array('unknown' => true), true);
    }
}
