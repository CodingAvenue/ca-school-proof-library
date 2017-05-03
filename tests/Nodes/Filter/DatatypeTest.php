<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Datatype;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;

class DatatypeTest extends TestCase
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
        $datatype = new Datatype('datatype', array('name' => 'string'), true);
        $this->assertInstanceOf(Datatype::class, $datatype, "\$datatype is an instance of the Datatype class");
    }

    public function testGetRuleClass()
    {
        $datatype = new Datatype('datatype', array('name' => 'string'), true);

        $rule = $datatype->getRuleClass();
        $this->assertInstanceOf(Rule::class, $rule, "getRuleClass returns an instance of the Rule class");
    }

    public function testApplyFilter()
    {
        $datatype = new Datatype('datatype', array('name' => 'string'), true);
        $node = $datatype->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(4, count($node), "The returned array has 1 elements");

        $datatype = new Datatype('datatype', array('name' => 'array'), true);
        $node = $datatype->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(1, count($node), "The returned array has 1 element");

        $datatype = new Datatype('datatype', array('name' => 'arrayfetch'), true);
        $node = $datatype->applyFilter($this->nodes);

        $this->assertInternalType('array', $node, "applyRule returns an array");
        $this->assertEquals(1, count($node), "The returned array has 1 element");
    }
}
