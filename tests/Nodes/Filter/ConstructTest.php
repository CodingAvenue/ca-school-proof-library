<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Construct;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;

class ConstructTest extends TestCase
{
    protected $nodes;

    public function setUp()
    {
        $code = <<<'CODE'
<?php

$firstName = "Foo";
$list = array('banana', 'apple', 'melon');
echo $list[2];
CODE;

        $this->nodes = (new Parser())->parse($code);
    }

    public function testInstance()
    {
        $echo = new Construct('construct', array('name' => 'echo'), true);
        $this->assertInstanceOf(Construct::class, $echo, "\$echo is an instance of the Datatype class");
    }

    public function testGetRuleClass()
    {
        $echo = new Construct('construct', array('name' => 'echo'), true);

        $rule = $echo->getRuleClass();
        $this->assertInstanceOf(Rule::class, $rule, "getRuleClass returns an instance of the Rule class");
    }

    public function testApplyFilter()
    {
        $echo = new Construct('construct', array('name' => 'echo'), true);
        $node = $echo->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(1, count($node), "The returned array has 1 elements");

    }
}
