<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\FilterFactory;
use CodingAvenue\Proof\Nodes\Filter\Operator;
use CodingAvenue\Proof\Nodes\Filter\Variable;
use CodingAvenue\Proof\Nodes\Filter\Interpolation;
use CodingAvenue\Proof\Nodes\Filter\Construct;
use CodingAvenue\Proof\Nodes\Filter\Datatype;
use CodingAvenue\Proof\Nodes\Filter\Function_;
use CodingAvenue\Proof\Nodes\Filter\Call;

class FilterFactoryTest extends TestCase
{
    public function testOperatorInstance()
    {
        $filter = FilterFactory::createFilter('operator', array('name' => 'assignment'), true);

        $this->assertInstanceOf(Operator::class, $filter, "FilterFactory can return an instance of the Operator class");
    }

    public function testVariableInstance()
    {
        $variable = FilterFactory::createFilter('variable', array(), true);

        $this->assertInstanceOf(Variable::class, $variable, "FilterFactory can return an instance of the Variable class");
    }

    public function testInterpolationInstance()
    {
        $interpolate = FilterFactory::createFilter('interpolation', array(), true);

        $this->assertInstanceOf(Interpolation::class, $interpolate, "FilterFactory can return an instance of the Interpolation class");
    }

    public function testConstructInstance()
    {
        $construct = FilterFactory::createFilter('construct', array('name' => 'echo'), true);

        $this->assertInstanceOf(Construct::class, $construct, "FilterFactory can return an instance of the Construct class");
    }

    public function testDataTypeInstance()
    {
        $data = FilterFactory::createFilter('datatype', array('name' => 'string'), true);

        $this->assertInstanceOf(Datatype::class, $data, "FilterFactory can return an instance of the Datatype class");
    }

    public function testFunctionInstance()
    {
        $data = FilterFactory::createFilter('function', array('name' => 'functionName'), true);

        $this->assertInstanceOf(Function_::class, $data, "FilterFactory can return an instance of the Function_ class");
    }

    public function testCallInstance()
    {
        $data = FilterFactory::createFilter('call', array('name' => 'functionName'), true);

        $this->assertInstanceOf(Call::class, $data, "FilterFactory can return an instance of the Call class");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $random = FilterFactory::createFilter('unknown', array(), true);
    }
}
