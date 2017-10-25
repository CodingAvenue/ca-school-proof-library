<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\ErrorSuppress;

class ErrorSuppressRuleTest extends TestCase
{
    public function testInstance()
    {
        $errorSuppress = new ErrorSuppress(array(), true);
        $this->assertInstanceOf(ErrorSuppress::class, $errorSuppress, "\$errorSuppress is an instance of the ErrorSuppress class");
    }

    public function testGetRule()
    {
        $errorSuppress = new ErrorSuppress(array(), true);

        $this->assertInternalType('callable', $errorSuppress->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('aNumber', array('startLine' => 1, 'endLine' => 1));
        $errorSuppressNode = new \PhpParser\Node\Expr\ErrorSuppress($variable, array('startLine' => 1, 'endLine' => 1));

        $errorSuppress = new ErrorSuppress(array(), true);
        $rule = $errorSuppress->getRule();
        $this->assertEquals(true, $rule($errorSuppressNode), "The callback returns true on the nodes with Error Suppress");
        $this->assertEquals(false, $rule($variable), "The callback returns false on the nodes without Error Suppress");

    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $errorSuppress = new ErrorSuppress(array('unknown' => 'name'), true);
    }
}
