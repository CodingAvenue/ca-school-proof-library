<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Call;

class CallRuleTest extends TestCase
{
    public function testInstance()
    {
        $Call = new Call(array(), true);

        $this->assertInstanceOf(Call::class, $Call, "\$Call is an instance of the Call class");
    }

    public function testGetRule()
    {
        $Call = new Call(array(), true);

        $this->assertInternalType('callable', $Call->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $name = new \PhpParser\Node\Name('addMe', array('startLine' => 1, 'endLine' => 1));       
        $CallNode = new \PhpParser\Node\Expr\FuncCall($name, array(), array('startLine' => 1, 'endLine' => 1));

        $Call = new Call(array(), true);
        $rule = $Call->getRule();
        $this->assertEquals(true, $rule($CallNode), "The callback returns true");

        $Call = new Call(array('name' => 'addMe'), true);
        $rule = $Call->getRule();
        $this->assertEquals(true, $rule($CallNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Call = new Call(array('unknown' => 'name'), true);
    }
}
