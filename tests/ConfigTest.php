<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Config;

class ConfigTest extends TestCase
{
    public function testConstructWithoutEnv()
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config, "\$config is an instance of Config class");
    }

    public function testConstructWithEnv()
    {
        putenv("PROOF_LIBRARY_MODE=local");
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config, "\$config is an instance of Config class");
        putenv("PROOF_LIBRARY_MODE");
    }

    public function testProperties()
    {
        putenv("PROOF_LIBRARY_MODE=local");
        $settings = array(
            "codeFilePath" => "./code"
        );
        fwrite(fopen('./proof.json', 'w'), json_encode($settings));

        $config = new Config();
        
        $this->assertEquals("./code", $config->getCodeFilePath(), "codeFilePath property is './code");
        $this->assertEquals(false, $config->isDefaultConfiguration(), "config is not using the default configuration");
        $this->assertEquals("answers", $config->getAnswerDir(), "answerDir is answers");
        $this->assertEquals("tests", $config->getProofDir(), "proofDir is tests");
    }

    public static function tearDownAfterClass()
    {
        putenv("PROOF_LIBRARY_MODE");
        unlink("./proof.json");
    }    
}
