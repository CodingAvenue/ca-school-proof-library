<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;
use CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Variable;
use CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Interpolation;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Subtraction;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Pow;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Multiplication;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Modulo;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Division;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Addition;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Equal;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Greater;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\GreaterEqual;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Identical;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Less;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\LessEqual;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotEqual;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotIdentical;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Spaceship;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\AssignConcat;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\Concat;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment;
use CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Call;
use CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Function_;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\String_;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Array_;
use CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Arrayfetch;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Echo_;
use CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Return_;

class RuleFactoryTest extends TestCase
{
    public function testVariable()
    {
        $rule = RuleFactory::createRule('variable', array(), true);

        $this->assertInstanceOf(Variable::class, $rule, "RuleFactory can return an instance of the Variable class");
    }

    public function testInterpolation()
    {
        $rule = RuleFactory::createRule('interpolation', array(), true);

        $this->assertInstanceOf(Interpolation::class, $rule, "RuleFactory can return an instance of the Interpolation class");
    }

    public function testSubtraction()
    {
        $rule = RuleFactory::createRule('subtraction', array(), true);

        $this->assertInstanceOf(Subtraction::class, $rule, "RuleFactory can return an instance of the Subtraction class");
    }

    public function testPow()
    {
        $rule = RuleFactory::createRule('pow', array(), true);

        $this->assertInstanceOf(Pow::class, $rule, "RuleFactory can return an instance of the Pow class");
    }

    public function testMultiplcation()
    {
        $rule = RuleFactory::createRule('multiplication', array(), true);

        $this->assertInstanceOf(Multiplication::class, $rule, "RuleFactory can return an instance of the Multiplication class");
    }

    public function testModulo()
    {
        $rule = RuleFactory::createRule('modulo', array(), true);

        $this->assertInstanceOf(Modulo::class, $rule, "RuleFactory can return an instance of the Modulo class");
    }

    public function testDivision()
    {
        $rule = RuleFactory::createRule('division', array(), true);

        $this->assertInstanceOf(Division::class, $rule, "RuleFactory can return an instance of the Division class");
    }

    public function testAddition()
    {
        $rule = RuleFactory::createRule('addition', array(), true);

        $this->assertInstanceOf(Addition::class, $rule, "RuleFactory can return an instance of the Addition class");
    }

    public function testEqual()
    {
        $rule = RuleFactory::createRule('equal', array(), true);

        $this->assertInstanceOf(Equal::class, $rule, "RuleFactory can return an instance of the Equal class");
    }

    public function testGreater()
    {
        $rule = RuleFactory::createRule('greater', array(), true);

        $this->assertInstanceOf(Greater::class, $rule, "RuleFactory can return an instance of the Greater class");
    }

    public function testGreaterEqual()
    {
        $rule = RuleFactory::createRule('greater-equal', array(), true);

        $this->assertInstanceOf(GreaterEqual::class, $rule, "RuleFactory can return an instance of the GreaterEqual class");
    }

    public function testIdentical()
    {
        $rule = RuleFactory::createRule('identical', array(), true);

        $this->assertInstanceOf(Identical::class, $rule, "RuleFactory can return an instance of the Identical class");
    }

    public function testLess()
    {
        $rule = RuleFactory::createRule('less', array(), true);

        $this->assertInstanceOf(Less::class, $rule, "RuleFactory can return an instance of the Less class");
    }

    public function testLessEqual()
    {
        $rule = RuleFactory::createRule('less-equal', array(), true);

        $this->assertInstanceOf(LessEqual::class, $rule, "RuleFactory can return an instance of the Less Equal class");
    }

    public function testNotEqual()
    {
        $rule = RuleFactory::createRule('not-equal', array(), true);

        $this->assertInstanceOf(NotEqual::class, $rule, "RuleFactory can return an instance of the Not Equal class");
    }

    public function testNotIdentical()
    {
        $rule = RuleFactory::createRule('not-identical', array(), true);

        $this->assertInstanceOf(NotIdentical::class, $rule, "RuleFactory can return an instance of the NotIdentical class");
    }

    public function testSpaceship()
    {
        $rule = RuleFactory::createRule('spaceship', array(), true);

        $this->assertInstanceOf(Spaceship::class, $rule, "RuleFactory can return an instance of the Spaceship class");
    }

    public function testAssignConcat()
    {
        $rule = RuleFactory::createRule('assign-concat', array(), true);

        $this->assertInstanceOf(AssignConcat::class, $rule, "RuleFactory can return an instance of the Assign Concat class");
    }

    public function testConcat()
    {
        $rule = RuleFactory::createRule('concat', array(), true);

        $this->assertInstanceOf(Concat::class, $rule, "RuleFactory can return an instance of the Concat class");
    }

    public function testAssignment()
    {
        $rule = RuleFactory::createRule('assignment', array(), true);

        $this->assertInstanceOf(Assignment::class, $rule, "RuleFactory can return an instance of the Assignment class");
    }

    public function testFunctionDefinition()
    {
        $rule = RuleFactory::createRule('function', array('name' => 'foo'), true);

        $this->assertInstanceOf(Function_::class, $rule, "RuleFactory can return an instance of the Function_ class");
    }

    public function testFunctionCall()
    {
        $rule = RuleFactory::createRule('call', array('name' => 'foo'), true);

        $this->assertInstanceOf(Call::class, $rule, "RuleFactory can return an instance of the Call class");
    }

    public function testString()
    {
        $rule = RuleFactory::createRule('string', array(), true);

        $this->assertInstanceOf(String_::class, $rule, "RuleFactory can return an instance of the String_ class");
    }

    public function testArray()
    {
        $rule = RuleFactory::createRule('array', array(), true);

        $this->assertInstanceOf(Array_::class, $rule, "RuleFactory can return an instance of the Array_ class");
    }

    public function testArrayFetch()
    {
        $rule = RuleFactory::createRule('arrayfetch', array(), true);

        $this->assertInstanceOf(Arrayfetch::class, $rule, "RuleFactory can return an instance of the Arrayfetch class");
    }

    public function testEcho()
    {
        $rule = RuleFactory::createRule('echo', array(), true);

        $this->assertInstanceOf(Echo_::class, $rule, "RuleFactory can return an instance of the Echo_ class");
    }

    public function testReturn()
    {
        $rule = RuleFactory::createRule('return', array(), true);

        $this->assertInstanceOf(Return_::class, $rule, "RuleFactory can return an instance of the Return_ class");
    }
}
