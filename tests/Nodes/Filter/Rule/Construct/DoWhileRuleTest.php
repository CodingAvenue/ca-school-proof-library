<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\DoWhile;

class DoWhileRuleTest extends TestCase
{
    public function testInstance()
    {
        $doWhile = new DoWhile(array(), true);

        $this->assertInstanceOf(DoWhile::class, $doWhile, "\$doWhile is an instance of the DoWhile class");
    }

    public function testGetRule()
    {
        $doWhile = new DoWhile(array(), true);

        $this->assertInternalType('callable', $doWhile->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $doWhileNode = new PhpParser\Node\Stmt\Do_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $doWhile = new DoWhile(array(), true);
        $rule = $doWhile->getRule();

        $this->assertEquals(true, $rule($doWhileNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $doWhile = new DoWhile(array('unknown' => 'name'), true);
    }
}
