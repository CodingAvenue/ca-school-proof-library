<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Array_;

class ArrayRuleTest extends TestCase
{
    public function testInstance()
    {
        $array = new Array_(array(), true);

        $this->assertInstanceOf(Array_::class, $array, "\$array is an instance of the Array_ class");
    }

    public function testGetRule()
    {
        $array = new Array_(array(), true);

        $this->assertInternalType('callable', $array->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $itemNode = new PhpParser\Node\Expr\ArrayItem($valueNode, null, false, array('startLine' => 1, 'endLine' => 1));        
        $arrayNode = new PhpParser\Node\Expr\Array_(array($itemNode), array('startLine' => 1, 'endLine' => 1, 'kind' => 1));

        $array = new Array_(array(), true);
        $rule = $array->getRule();

        $this->assertEquals(true, $rule($arrayNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $keyNode = new PhpParser\Node\Scalar\String_('key1', array('startLine' => 1, 'endLine' => 1));
        $itemNode = new PhpParser\Node\Expr\ArrayItem($valueNode, $keyNode, false, array('startLine' => 1, 'endLine' => 1));
        $arrayNode = new PhpParser\Node\Expr\Array_(array($itemNode), array('startLine' => 1, 'endLine' => 1));

        $array = new Array_(array('type' => 'associative'), true);
        $rule = $array->getRule();

        $this->assertEquals(true, $rule($arrayNode), "The callback returns true");
        $array = new Array_(array('type' => 'indexed'), true);
        $rule = $array->getRule();
        $this->assertEquals(false, $rule($arrayNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $array = new Array_(array('unknown' => 'name'), true);
    }
}
