<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Code\NodeFinder;
use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Code\NodesFilter;

class NodeFinderTest extends TestCase
{
    protected static $nodes;

    public static function setUpBeforeClass()
    {
        $raw = <<<PHPCODE
<?php

\$first = "First Name";
\$last = "Last Name";

echo "My Name is: {\$first}{\$last}";
PHPCODE;

        self::$nodes = Parser::parse($raw);
    }

    public function testInstance()
    {
        $finder = new NodeFinder();
        $this->assertInstanceOf(NodeFinder::class, $finder, "\$finder is an instance of NodeFinder");
    }

    public function testApplyFilter()
    {
        $finder = new NodeFinder();
        $filter = new NodesFilter(true);
        $filter->setAction('variable');
        $filter->setParams(array("name" => "first"));

        $nodes = $finder->applyFilter($filter, self::$nodes);

        $this->assertEquals(2, count($nodes), "count() will return 2 since the variable first was used twice");
    }

    public function testFindVariable()
    {
        $finder = new NodeFinder();
        $params = array("name" => "first");

        $nodes = $finder->findVariable(self::$nodes, $params, true);
        $this->assertEquals(2, count($nodes), "count() will return 2 since the variable first was used twice");
    }

    public function testFindInterpolation()
    {
        $finder = new NodeFinder();
        
        $nodes = $finder->findInterpolation(self::$nodes, array(), true);
        $this->assertEquals(1, count($nodes), "variable interpolation only happens once");
    }

    public function testFindEncapsedString()
    {
        $finder = new NodeFinder();

        $nodes = $finder->findEncapsedString(self::$nodes, array(), true);

        $this->assertEquals(1, count($nodes), "There is only one node that has a variable interpolation with another string concat to it.");
    }

    public function testFindOperator()
    {
        $finder = new NodeFinder();

        $nodes = $finder->findOperator(self::$nodes, array("name" => "echo"), true);

        $this->assertEquals(1, count($nodes), "Only one echo operator found");
    }

    public function testFindConstruct()
    {
        $finder = new NodeFinder();

        $nodes = $finder->findConstruct(self::$nodes, array("name" => "echo"), true);

        $this->assertEquals(1, count($nodes), "Only one echo construct found");
    }

    public function testFindString()
    {
        $finder = new NodeFinder();

        $nodes = $finder->findString(self::$nodes, array(), true);

        $this->assertEquals(3, count($nodes), "3 nodes found with a string literal on it.");
    }
}
