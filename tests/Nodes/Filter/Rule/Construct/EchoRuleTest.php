<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Echo_;

class EchoRuleTest extends TestCase
{
    public function testInstance()
    {
        $echo = new Echo_(array(), true);

        $this->assertInstanceOf(Echo_::class, $echo, "\$echo is an instance of the Echo_ class");
    }

    public function testGetRule()
    {
        $echo = new Echo_(array(), true);

        $this->assertInternalType('callable', $echo->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $valueNode = new PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $echoNode = new PhpParser\Node\Stmt\Echo_(array($valueNode), array('startLine' => 1, 'endLine' => 1));

        $echo = new Echo_(array(), true);
        $rule = $echo->getRule();

        $this->assertEquals(true, $rule($echoNode), "The callback returns true");
        $this->assertEquals(false, $rule($valueNode), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $echo = new Echo_(array('unknown' => 'name'), true);
    }
}
