<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Interpolation;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;

class InterpolationTest extends TestCase
{
    protected $nodes;

    public function setUp()
    {
        $code = <<<'CODE'
<?php

$firstName = "Foo";
$lastName = "Bar";
echo "My name is $firstName\n";
CODE;

        $this->nodes = (new Parser())->parse($code);
    }

    public function testInstance()
    {
        $interpolation = new Interpolation('interpolation', array(), true);
        $this->assertInstanceOf(Interpolation::class, $interpolation, "\$interpolation is an instance of the Interpolation class");
    }

    public function testGetRuleClass()
    {
        $interpolation = new Interpolation('interpolation', array(), true);

        $rule = $interpolation->getRuleClass();
        $this->assertInstanceOf(Rule::class, $rule, "getRuleClass returns an instance of the Rule class");
    }

    public function testApplyFilter()
    {
        $interpolation = new Interpolation('interpolation', array(), true);

        $node = $interpolation->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "variable interpolation was only used once");
    }
}
