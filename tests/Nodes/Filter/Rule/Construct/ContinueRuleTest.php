<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Continue_;

class ContinueRuleTest extends TestCase
{
    public function testInstance()
    {
        $continue = new Continue_(array(), true);

        $this->assertInstanceOf(Continue_::class, $continue, "\$continue is an instance of the Continue_ class");
    }

    public function testGetRule()
    {
        $continue = new Continue_(array(), true);

        $this->assertInternalType('callable', $continue->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $numNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $continueNode = new \PhpParser\Node\Stmt\Continue_($numNode);
        
        $continue = new Continue_(array(), true);
        $rule = $continue->getRule();

        $this->assertEquals(true, $rule($continueNode), "The callback returns true");
        $this->assertEquals(false, $rule($numNode), "The callback return false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $continue = new Continue_(array('unknown' => 'name'), true);
    }
}
