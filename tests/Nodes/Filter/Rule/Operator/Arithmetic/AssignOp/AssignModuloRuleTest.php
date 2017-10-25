<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Modulo;

class AssignModuloRuleTest extends TestCase
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
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignModulo = new \PhpParser\Node\Expr\AssignOp\Mod($variable, $nextValue);

        $Modulo = new Modulo(array(), true);
        $rule = $Modulo->getRule();
        $this->assertEquals(true, $rule($assignModulo), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Modulo = new Modulo(array('unknown' => 'name'), true);
    }
}
