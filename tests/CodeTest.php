<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Code;
use CodingAvenue\Proof\Config;
use CodingAvenue\Proof\Analyzer;
use CodingAvenue\Proof\Evaluator;
use CodingAvenue\Proof\Nodes\Nodes;

class CodeTest extends TestCase
{
    protected static $code;

    public static function setUpBeforeClass()
    {
        putenv("PROOF_LIBRARY_MODE=local");
        fwrite(fopen('./code', 'w'), '<?php\n\n echo "Hello World\n";\n');

        $settings = array(
            "codeFilePath" => "./code"
        );
        fwrite(fopen('./proof.json', 'w'), json_encode($settings));

        self::$code = new Code();
    }

    public function testCodeInstance()
    {
        $this->assertInstanceOf(Code::class, self::$code, "\$code is not an instance of Code");
    }

    public function testConfigInstance()
    {
        $this->assertInstanceOf(Config::class, self::$code->getConfig(), "\$code->getConfig() is not an instance of Config");
    }

    public function testParse()
    {
        $this->assertInternalType('array', self::$code->parse(), 'parse() returns an array');
    }

    public function testAnalyzerInstance()
    {
        $this->assertInstanceOf(Analyzer::class, self::$code->analyzer(), 'analyzer() returns an instance of Analyzer class');
    }

    public function testEvaluatorInstance()
    {
        $this->assertInstanceOf(Evaluator::class, self::$code->evaluator(), 'evaluator() returns an instance of Evaluator class');
    }

    public function testNodesInstance()
    {
        $this->assertInstanceOf(Nodes::class, self::$code->getNodes(), 'getNodes() returns an instance of Nodes class');
    }

    public static function tearDownAfterClass()
    {
        putenv("PROOF_LIBRARY_MODE");
        unlink("./proof.json");
        unlink("./code");
    }
}
