<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Return_;

class ReturnRuleTest extends TestCase
{
    public function testInstance()
    {
        $return = new Return_(array(), true);

        $this->assertInstanceOf(Return_::class, $return, "\$return is an instance of the Return_ class");
    }

    public function testGetRule()
    {
        $return = new Return_(array(), true);

        $this->assertInternalType('callable', $return->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $returnNode = new PhpParser\Node\Stmt\Return_($valueNode, array('startLine' => 1, 'endLine' => 1));

        $return = new Return_(array(), true);
        $rule = $return->getRule();

        $this->assertEquals(true, $rule($returnNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $return = new Return_(array('unknown' => 'name'), true);
    }
}
