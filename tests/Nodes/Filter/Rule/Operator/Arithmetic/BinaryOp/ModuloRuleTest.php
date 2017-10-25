<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Modulo;

class ModuloRuleTest extends TestCase
{
    public function testInstance()
    {
        $Modulo = new Modulo(array(), true);

        $this->assertInstanceOf(Modulo::class, $Modulo, "\$Modulo is an instance of the Modulo class");
    }

    public function testGetRule()
    {
        $Modulo = new Modulo(array(), true);

        $this->assertInternalType('callable', $Modulo->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $ModuloNode = new \PhpParser\Node\Expr\BinaryOp\Mod($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Modulo = new Modulo(array(), true);
        $rule = $Modulo->getRule();
        $this->assertEquals(true, $rule($ModuloNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Modulo = new Modulo(array('unknown' => 'name'), true);
    }
}
