<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Switch_;

class SwitchRuleTest extends TestCase
{
    public function testInstance()
    {
        $switch = new Switch_(array(), true);

        $this->assertInstanceOf(Switch_::class, $switch, "\$switch is an instance of the Switch_ class");
    }

    public function testGetRule()
    {
        $switch = new Switch_(array(), true);

        $this->assertInternalType('callable', $switch->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $switchNode = new PhpParser\Node\Stmt\Switch_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $switch = new Switch_(array(), true);
        $rule = $switch->getRule();

        $this->assertEquals(true, $rule($switchNode), "The callback returns true");

        $caseNode = new PhpParser\Node\Stmt\Case_(null, array(), array('startLine' => 1, 'endLine' => 1));
        $switchNode = new PhpParser\Node\Stmt\Switch_($valueNode, array($caseNode), array('startLine' => 1, 'endLine' => 1));

        $switch = new Switch_(array(), true);
        $rule = $switch->getRule();

        $this->assertEquals(true, $rule($switchNode), "The callback returns true");

        $switch = new Switch_(array('hasDefault' => 'true'), true);
        $rule = $switch->getRule();

        $this->assertEquals(true, $rule($switchNode), "The callback returns true");

        $switch = new Switch_(array('hasDefault' => 'false'), true);
        $rule = $switch->getRule();

        $this->assertEquals(false, $rule($switchNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $switch = new Switch_(array('unknown' => 'name'), true);
    }
}
