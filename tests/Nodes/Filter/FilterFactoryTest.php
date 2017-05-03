<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\FilterFactory;
use CodingAvenue\Proof\Nodes\Filter\Operator;
use CodingAvenue\Proof\Nodes\Filter\Variable;
use CodingAvenue\Proof\Nodes\Filter\Interpolation;
use CodingAvenue\Proof\Nodes\Filter\Construct;
use CodingAvenue\Proof\Nodes\Filter\Datatype;

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

    public function testException()
    {
        $this->expectException(Exception::class);

        $random = FilterFactory::createFilter('unknown', array(), true);
    }
}
