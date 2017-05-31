<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\String_;

class StringRuleTest extends TestCase
{
    public function testInstance()
    {
        $string = new String_(array(), true);

        $this->assertInstanceOf(String_::class, $string, "\$string is an instance of the String_ class");
    }

    public function testGetRule()
    {
        $string = new String_(array(), true);

        $this->assertInternalType('callable', $string->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $stringNode = new PhpParser\Node\Scalar\String_('Hi There', array('startLine' => 1, 'endLine' => 1, 'kind' => 2));       

        $string = new String_(array(), true);
        $rule = $string->getRule();
        $this->assertEquals(true, $rule($stringNode), "The callback returns true");

        $string = new String_(array('value' => 'Hi There'), true);
        $rule = $string->getRule();
        $this->assertEquals(true, $rule($stringNode), "The callback returns true");

        $string = new String_(array('value' => 'Hi There', 'type' => 'double'), true);
        $rule = $string->getRule();
        $this->assertEquals(true, $rule($stringNode), "The callback returns true");

        $string = new String_(array('value' => 'Hi There', 'type' => 'single'), true);
        $rule = $string->getRule();
        $this->assertEquals(false, $rule($stringNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $string = new String_(array('unknown' => 'name'), true);
    }
}
