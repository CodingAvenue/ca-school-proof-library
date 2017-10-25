<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanNot;

class BooleanNotRuleTest extends TestCase
{
    public function testInstance()
    {
        $booleanNot = new BooleanNot(array(), true);

        $this->assertInstanceOf(BooleanNot::class, $booleanNot, "\$booleanNot is an instance of the BooleanNot class");
    }

    public function testGetRule()
    {
        $booleanNot = new BooleanNot(array(), true);

        $this->assertInternalType('callable', $booleanNot->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $num = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $booleanNotNode = new \PhpParser\Node\Expr\BooleanNot($num, array('startLine' => 1, 'endLine' => 1));

        $booleanNot = new BooleanNot(array(), true);
        $rule = $booleanNot->getRule();
        $this->assertEquals(true, $rule($booleanNotNode), "The callback returns true");
        $this->assertEquals(false, $rule($num), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $booleanNot = new BooleanNot(array('unknown' => 'name'), true);
    }
}
