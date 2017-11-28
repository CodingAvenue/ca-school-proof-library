<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Function_;

class FunctionRuleTest extends TestCase
{
    public function testInstance()
    {
        $func = new Function_(array(), true);

        $this->assertInstanceOf(Function_::class, $func, "\$funcl is an instance of the Function_ class");
    }

    public function testGetRule()
    {
        $func = new Function_(array(), true);

        $this->assertInternalType('callable', $func->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $funcNode = new PhpParser\Node\Stmt\Function_('addMe', array(), array('startLine' => 1, 'endLine' => 1));       

        $func = new Function_(array(), true);
        $rule = $func->getRule();
        $this->assertEquals(true, $rule($funcNode), "The callback returns true");

        $func = new Function_(array('name' => 'addMe'), true);
        $rule = $func->getRule();
        $this->assertEquals(true, $rule($funcNode), "The callback returns true");

        $paramNodes = array(
            new PhpParser\Node\Param(
                new PhpParser\Node\Expr\Variable('num'), null, null, true
            )
        );

        $subNodes = array(
            'params' => $paramNodes
        );

        $funcNode = new PhpParser\Node\Stmt\Function_('addMe', $subNodes);
        $func = new Function_(array('name' => 'addMe', 'paramsByRefs' => 'num'));
        $rule = $func->getRule();
        $this->assertEquals(true, $rule($funcNode), "The callback returns true");

        $paramNodes = array(
            new PhpParser\Node\Param(
                new PhpParser\Node\Expr\Variable('num'), null, null, true
            ),
            new PhpParser\Node\Param(
                new PhpParser\Node\Expr\Variable('num2'), null, null, true
            )
        );

        $subNodes = array(
            'params' => $paramNodes
        );

        $funcNode = new PhpParser\Node\Stmt\Function_('addMe', $subNodes);
        $func = new Function_(array('name' => 'addMe', 'paramsByRefs' => 'num, num2'));
        $rule = $func->getRule();
        $this->assertEquals(true, $rule($funcNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $func = new Function_(array('unknown' => 'name'), true);
    }
}
