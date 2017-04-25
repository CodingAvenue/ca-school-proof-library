<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Evaluator;

class EvaluatorTest extends TestCase
{
    public function testConstructor()
    {
        $code = "echo 'hello World';";

        $evaluator = new Evaluator($code);
        $result = $evaluator->evaluate();

        $this->assertInstanceOf(Evaluator::class, $evaluator, "\$evaluator is an instance of Evaluator class");
    }

    public function testOutput()
    {
        $code = "echo 'hello World';";

        $evaluator = new Evaluator($code);
        $result = $evaluator->evaluate();

        $this->assertEquals("hello World", $result['output'], "The evaulated output is hello World");
    }

    public function testReturn()
    {
        $code = "return 'hello';";

        $evaluator = new Evaluator($code);
        $result = $evaluator->evaluate();

        $this->assertEquals("hello", $result['result'], "The evaulated result is hello");
    }

    public function testError()
    {
        $code = "echo 'hello World'";

        $evaluator = new Evaluator($code);
        $result = $evaluator->evaluate(); 

        $this->assertEquals("syntax error, unexpected end of file, expecting ',' or ';' at line 1", $result['error'], "Evaluator will give us the syntax error");
    }
}
