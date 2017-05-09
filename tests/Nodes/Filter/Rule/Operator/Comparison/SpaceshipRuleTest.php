<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Spaceship;

class SpaceshipRuleTest extends TestCase
{
    public function testInstance()
    {
        $Spaceship = new Spaceship(array(), true);

        $this->assertInstanceOf(Spaceship::class, $Spaceship, "\$Spaceship is an instance of the Spaceship class");
    }

    public function testGetRule()
    {
        $Spaceship = new Spaceship(array(), true);

        $this->assertInternalType('callable', $Spaceship->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\Spaceship($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Spaceship = new Spaceship(array(), true);
        $rule = $Spaceship->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Spaceship = new Spaceship(array('unknown' => 'name'), true);
    }
}
