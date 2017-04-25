<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Code\NodesFilter;

class NodesFilterTest extends TestCase
{
    public function testInstance()
    {
        $filter = new NodesFilter(true);

        $this->assertInstanceOf(NodesFilter::class, $filter, "\$filter is an instance of NodesFilter");
    }

    public function testSetActionSuccess()
    {
        $filter = new NodesFilter(true);

        $filter->setAction('variable');

        $this->assertEquals('findVariable', $filter->getAction(), 'action was accepted');
    }

    public function testSetActionFailure()
    {
        $filter = new NodesFilter(true);
        $this->expectException(Exception::class);
        $filter->setAction('UNKNOWN ACTION');
    }

    public function testGetSetParams()
    {
        $filter = new NodesFilter(true);

        $filter->setParams(array("name" => "I am a params"));

        $this->assertInternalType("array", $filter->getParams(), "getParams() returns the same type of what was given on setParams()");

        $this->assertEquals("I am a params", $filter->getParams()['name'], "The name key has the same exact value as to what was given");
    }
}
