<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\If_;

class IfRuleTest extends TestCase
{
    public function testInstance()
    {
        $if = new If_(array(), true);

        $this->assertInstanceOf(If_::class, $if, "\$if is an instance of the If_ class");
    }

    public function testGetRule()
    {
        $if = new If_(array(), true);

        $this->assertInternalType('callable', $if->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $ifNode = new PhpParser\Node\Stmt\If_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));

        $if = new If_(array(), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $if = new If_(array('hasElseIfs' => 'false', 'hasElse' => 'false'), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");

        $elseifs = new PhpParser\Node\Stmt\ElseIf_($valueNode, array(), array('startLine' => 1, 'endLine' => 1));
        $ifNode = new PhpParser\Node\Stmt\If_($valueNode, array('elseifs' => array($elseifs)), array('startLine' => 1, 'endLine' => 1));

        $if = new If_(array(), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");        

        $if = new If_(array('hasElseIfs' => 'true'), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");

        $if = new If_(array('hasElseIfs' => 'false'), true);
        $rule = $if->getRule();

        $this->assertEquals(false, $rule($ifNode), "The callback returns false");

        $else = new PhpParser\Node\Stmt\Else_(array(), array('startLine' => 1, 'endLine' => 1));
        $ifNode = new PhpParser\Node\Stmt\If_($valueNode, array('elseifs' => array($elseifs), 'else' => $else), array('startLine' => 1, 'endLine' => 1));

        $if = new If_(array(), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");        

        $if = new If_(array('hasElseIfs' => 'true'), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");

        $if = new If_(array('hasElseIfs' => 'false'), true);
        $rule = $if->getRule();

        $this->assertEquals(false, $rule($ifNode), "The callback returns false");
        
        $if = new If_(array('hasElse' => 'true'), true);
        $rule = $if->getRule();

        $this->assertEquals(true, $rule($ifNode), "The callback returns true");

        $if = new If_(array('hasElse' => 'false'), true);
        $rule = $if->getRule();

        $this->assertEquals(false, $rule($ifNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $if = new If_(array('unknown' => 'name'), true);
    }
}
