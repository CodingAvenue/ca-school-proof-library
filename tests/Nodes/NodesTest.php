<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Code\Parser;

class NodesTest extends TestCase
{
    protected static $nodes;

    public static function setUpBeforeClass()
    {
        $raw = <<<PHPCODE
<?php

\$first = "First Name";
\$last = "Last Name";

echo "\$first \$last\n";
PHPCODE;

        self::$nodes = new Nodes(Parser::parse($raw));
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Nodes::class, self::$nodes, "\$nodes is an instance of Nodes class");
    }

    public function testFind()
    {
        $nodes = self::$nodes->find("variable[name='first']");
        $this->assertInstanceOf(Nodes::class, $nodes, "find() returns an instance of Nodes class");

        $count = $nodes->count();

        $this->assertEquals(2, $count, "There are two instance the variable \$first was used");
    }

    public function testGetNodes()
    {
        $this->assertInternalType('array', self::$nodes->getNodes(), "getNodes() returns the array of nodes");
    }

    public function testChildren()
    {
        $nodes = self::$nodes->children('variable[name="first"]');
        $this->assertInstanceOf(Nodes::class, $nodes, "children() will return a new instance of Nodes class");

        $this->assertEquals(1, $nodes->count(), "The result of children() give us a single node since variable first was onlye used once on it's direct children");
    }

    public function testText()
    {
        $nodes = self::$nodes->find('operator[name="assignment", variable="first"]');

        $this->assertEquals("First Name", $nodes->text(), "The string 'First Name' is returned by the text() method");
    }

    public function testCount()
    {
        $count = self::$nodes->count();

        $this->assertEquals(3, $count, "Count returns 3 nodes");
    }

    public function testGetSubnode()
    {
        $nodes = self::$nodes->getSubnode();

        $this->assertEquals(5, $nodes->count(), "Subnodes has 5 nodes on it");
    }

    public function testParserSelector()
    {
        $parsed = self::$nodes->parseSelector('operator');

        $this->assertInternalType('array', $parsed, 'ParseSelector returns an array');
        $this->assertEquals('operator', $parsed['node'], 'The node key returns operator string');
    }
}
