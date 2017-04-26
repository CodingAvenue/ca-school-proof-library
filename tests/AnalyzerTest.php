<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Analyzer;

class AnalyzerTest extends TestCase
{
    protected static $analyzer;

    public static function setUpBeforeClass()
    {
        $content = <<<PHPCODE
<?php

\$name = "Test Name";

echo "Hi \$name\n";

PHPCODE;
        fwrite(fopen('./code', 'w'), $content);

        self::$analyzer = new Analyzer('./code');
    }

    public function testInstance()
    {
        $this->assertInstanceOf(Analyzer::class, self::$analyzer, "\$analyzer is an instance of Analyzer class");
    }

    public function testCodingStandard()
    {
        $result = self::$analyzer->codingStandard();

        $this->assertInternalType('array', $result, "\$result is an array");
        $this->assertEquals(0, count($result), "There was no error on the result");
    }

    public function testMessDetection()
    {
        $result = self::$analyzer->messDetection();
        
        $this->assertInternalType('array', $result, "\$result is an array");
        $this->assertEquals(0, count($result), "There was no error on the result");
    }
}