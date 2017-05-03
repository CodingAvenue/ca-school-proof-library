<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Operator;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;

class OperatorTest extends TestCase
{
    protected $nodes;

    public function setUp()
    {
        $code = <<<'CODE'
<?php

$name = "Foo";
$name .= " Bar";
$another = "Bar " . "Baz";
$big = 10;
$small = 1;
$equal = $big == $small;
$greater = $big > $small;
$greaterequal = $big >= $small;
$identical = $big === $small;
$less = $big < $small;
$lessequal = $big <= $small;
$notequal = $big != $small;
$notidentical = $big !== $small;
$space = $big <=> $small;
$add = $big + $small;
$div = $big / $small;
$mod = $big % $small;
$mul = $big * $small;
$pow = $big ** $small;
$sub = $big - $small;
CODE;

        $this->nodes = (new Parser())->parse($code);
    }

    public function testInstance()
    {
        $operator = new Operator('operator', array('name' => 'assignment'), true);
        $this->assertInstanceOf(Operator::class, $operator, "\$oeprator is an instance of the Operator class");
    }

    public function testGetRuleClass()
    {
        $operator = new Operator('operator', array('name' => 'assignment'), true);

        $rule = $operator->getRuleClass();
        $this->assertInstanceOf(Rule::class, $rule, "getRuleClass returns an instance of the Rule class");
    }

    public function testApplyFilter()
    {
        $operator = new Operator('operator', array('name' => 'assignment'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(19, count($node), "Assignment operator was used 19 times");

        $operator = new Operator('operator', array('name' => 'assignment', 'variable' => 'name'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Assignment operator to variable 'name' was used 1 time");

        $operator = new Operator('operator', array('name' => 'concat'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Concat operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'assign-concat'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Assign Concat operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'equal'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Equal operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'greater'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Greater Than operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'greater-equal'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Greater or Equal operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'identical'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Identical operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'less'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Less than operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'less-equal'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Less than or equal operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'not-equal'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Not equal operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'not-identical'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Not Identical operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'spaceship'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Spaceship operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'addition'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Addition operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'division'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Div operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'modulo'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Modulo operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'multiplication'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Multiplication operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'pow'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Pow operator was used 1 time");

        $operator = new Operator('operator', array('name' => 'subtraction'), true);
        $node = $operator->applyFilter($this->nodes);
        $this->assertEquals(1, count($node), "Subtraction operator was used 1 time");
    }
}
