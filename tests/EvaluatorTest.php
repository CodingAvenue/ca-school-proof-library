<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Evaluator;
use CodingAvenue\Proof\Config;
use CodingAvenue\Proof\BinFinder;

class EvaluatorTest extends TestCase
{
    public function testConstructor()
    {
        $code = "<?php echo 'hello World';";
        fwrite(fopen('./code', 'w'), $code);

        $config = new Config();
        $binFinder = new BinFinder($config);

        $evaluator = new Evaluator('./code', $binFinder->getEvalRunner());
        $result = $evaluator->evaluate();

        $this->assertInstanceOf(Evaluator::class, $evaluator, "\$evaluator is an instance of Evaluator class");
    }

    public function testOutput()
    {
        $code = <<<'CODE'
    
<?php echo 'hello World';
CODE;
        fwrite(fopen('./code', 'w'), $code);

        $config = new Config();
        $binFinder = new BinFinder($config);

        $evaluator = new Evaluator('./code', $binFinder->getEvalRunner());
        $result = $evaluator->evaluate();

        $this->assertEquals("hello World", $result['output'], "The evaulated output is hello World");
    }

    public function testRepeatedEvaluation()
    {
        $code = <<<'CODE'
<?php
function add($first, $second)
{
    return $first + $second;
}

echo add(10, 5);
CODE;

        fwrite(fopen('./code', 'w'), $code);

        $config = new Config();
        $binFinder = new BinFinder($config);

        $evaluator = new Evaluator('./code', $binFinder->getEvalRunner());

        $result = $evaluator->evaluate();

        $this->assertEquals("15", $result['output'], "The evaluated output is 15");

        $evaluator = new Evaluator('./code', $binFinder->getEvalRunner());
        $result = $evaluator->evaluate();

        $this->assertEquals(15, $result['output'], "The evaluated output is 15");
    }

    public function testError()
    {
        $code = "<?php echo 'hello World'";
        fwrite(fopen('./code', 'w'), $code);

        $config = new Config();
        $binFinder = new BinFinder($config);

        $evaluator = new Evaluator('./code', $binFinder->getEvalRunner());
        $result = $evaluator->evaluate(); 

        $this->assertEquals("PHP Parse error:  syntax error, unexpected end of file, expecting ',' or ';' on line 1", $result['error'], "Evaluator will give us the syntax error");
    }

    public static function tearDownAfterClass()
    {
        unlink("./code");
    }
}
