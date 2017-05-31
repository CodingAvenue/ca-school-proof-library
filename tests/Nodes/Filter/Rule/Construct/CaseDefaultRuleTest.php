<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\CaseDefault;

class CaseDefaultRuleTest extends TestCase
{
    public function testInstance()
    {
        $caseDefault = new CaseDefault(array(), true);

        $this->assertInstanceOf(CaseDefault::class, $caseDefault, "\$caseDefault is an instance of the CaseDefault class");
    }

    public function testGetRule()
    {
        $caseDefault = new CaseDefault(array(), true);

        $this->assertInternalType('callable', $caseDefault->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $defaultNode = new PhpParser\Node\Stmt\Case_(null, array(), array('startLine' => 1, 'endLine' => 1));

        $default = new CaseDefault(array(), true);
        $rule = $default->getRule();

        $this->assertEquals(true, $rule($defaultNode), "The callback returns true");

        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $caseNode = new PhpParser\Node\Stmt\Case_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $case = new CaseDefault(array(), true);
        $rule = $case->getRule();

        $this->assertEquals(false, $rule($caseNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $caseDefault = new CaseDefault(array('unknown' => 'name'), true);
    }
}
