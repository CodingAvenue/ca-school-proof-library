<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\For_;

class ForRuleTest extends TestCase
{
    public function testInstance()
    {
        $for = new For_(array(), true);

        $this->assertInstanceOf(For_::class, $for, "\$for is an instance of the For_ class");
    }

    public function testGetRule()
    {
        $for = new For_(array(), true);

        $this->assertInternalType('callable', $for->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $forNode = new PhpParser\Node\Stmt\For_(array(), array('startLine' => 1, 'endLine' => 1));

        $for = new For_(array(), true);
        $rule = $for->getRule();

        $this->assertEquals(true, $rule($forNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $for = new For_(array('unknown' => 'name'), true);
    }
}
