<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Case_;

class CaseRuleTest extends TestCase
{
    public function testInstance()
    {
        $case = new Case_(array(), true);

        $this->assertInstanceOf(Case_::class, $case, "\$case is an instance of the Case_ class");
    }

    public function testGetRule()
    {
        $case = new Case_(array(), true);

        $this->assertInternalType('callable', $case->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $caseNode = new PhpParser\Node\Stmt\Case_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $case = new Case_(array(), true);
        $rule = $case->getRule();

        $this->assertEquals(true, $rule($caseNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $case = new Case_(array('isDefault' => 'true'), true);
        $rule = $case->getRule();

        $this->assertEquals(false, $rule($caseNode), "The callback returns false");

        $case = new Case_(array('isDefault' => 'false'), true);
        $rule = $case->getRule();

        $this->assertEquals(true, $rule($caseNode), "The callback returns true");

        $caseNode = new PhpParser\Node\Stmt\Case_(null, array(), array('startLine' => 1, 'endLine' => 1));

        $case = new Case_(array('isDefault' => 'true'), true);
        $rule = $case->getRule();

        $this->assertEquals(true, $rule($caseNode), "The callback returns true");

        $case = new Case_(array('isDefault' => 'false'), true);
        $rule = $case->getRule();

        $this->assertEquals(false, $rule($caseNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $case = new Case_(array('unknown' => 'name'), true);
    }
}
