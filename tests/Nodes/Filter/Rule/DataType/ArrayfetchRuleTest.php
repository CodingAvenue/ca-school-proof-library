<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Arrayfetch;

class ArrayfetchRuleTest extends TestCase
{
    public function testInstance()
    {
        $arrayFetch = new Arrayfetch(array(), true);

        $this->assertInstanceOf(Arrayfetch::class, $arrayFetch, "\$arrayFetch is an instance of the Arrayfetch class");
    }

    public function testGetRule()
    {
        $arrayFetch = new Arrayfetch(array(), true);

        $this->assertInternalType('callable', $arrayFetch->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $varNode = new PhpParser\Node\Expr\Variable('names', array('startLine' => 1, 'endLine' => 1));
        $dimNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $arrayFetchNode = new PhpParser\Node\Expr\ArrayDimFetch($varNode, $dimNode, array('startLine' => 1, 'endLine' => 1));

        $arrayFetch = new Arrayfetch(array(), true);
        $rule = $arrayFetch->getRule();
        $this->assertEquals(true, $rule($arrayFetchNode), "The callback returns true");

        $arrayFetch = new Arrayfetch(array('variable' => 'names'), true);
        $rule = $arrayFetch->getRule();
        $this->assertEquals(true, $rule($arrayFetchNode), "The callback returns true");

        $arrayFetch = new Arrayfetch(array('variable' => 'name'), true);
        $rule = $arrayFetch->getRule();
        $this->assertEquals(false, $rule($arrayFetchNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $arrayFetch = new Arrayfetch(array('unknown' => 'name'), true);
    }
}
