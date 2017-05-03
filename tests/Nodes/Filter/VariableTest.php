<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Variable;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;

class VariableTest extends TestCase
{
    protected $nodes;

    public function setUp()
    {
        $code = <<<CODE
<?php

\$firstName = "Foo";
\$lastName = "Bar";
echo "My name is \$firstName\n";
CODE;

        $this->nodes = (new Parser())->parse($code);
    }

    public function testInstance()
    {
        $variable = new Variable('variable', array('name' => 'firstName'), true);
        $this->assertInstanceOf(Variable::class, $variable, "\$variable is an instance of the Variable class");
    }

    public function testGetRuleClass()
    {
        $variable = new Variable('variable', array('name' => 'firstName'), true);

        $rule = $variable->getRuleClass();
        $this->assertInstanceOf(Rule::class, $rule, "getRuleClass returns an instance of the Rule class");
    }

    public function testApplyFilter()
    {
        $variable = new Variable('variable', array('name' => 'firstName'), true);

        $node = $variable->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(2, count($node), "The returned array has 2 elements");

        $variable = new Variable('variable', array(), true);

        $node = $variable->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(3, count($node), "The returned array has 2 elements");
    }
}
