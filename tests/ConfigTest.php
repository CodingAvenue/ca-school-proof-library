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

    public function testDefaultProperties()
    {
        $config = new Config();

        $this->assertEquals("/code", $config->getCodeFilePath(), "codeFilePath default setting is /code");
        $this->assertEquals(true, $config->isDefaultConfiguration(), "This is a default configuration");
        $this->assertEquals("", $config->getProofDir(), "Default proof dir is empty");
        $this->assertEquals("", $config->getAnswerDir(), "Default answer dir is empty");
        $this->assertEquals("vendor/bin", $config->getBinPath(), "Default bin path is 'vendor/bin'");
        $this->assertEquals(false, $config->isSuppressCodingConventionErrors(), "Suppress Coding Convention errors is default to false");
        $this->assertEquals(false, $config->isSuppressMessDetectionErrors(), "Suppress Mess Detection errors is default to false");
        $this->assertEquals(true, $config->isSandboxMode(), "Using default settings will be flagged as sandbox mode.");
    }

    public function testProperties()
    {
        putenv("PROOF_LIBRARY_MODE=local");
        $settings = array(
            "codeFilePath" => "./code",
            "proofDir" => "tests",
            "answerDir" => "answers",
            "suppressCodingConventionErrors" => true,
            "suppressMessDetectionErrors" => true
        );
        fwrite(fopen('./proof.json', 'w'), json_encode($settings));

        $config = new Config();
        
        $this->assertEquals("./code", $config->getCodeFilePath(), "codeFilePath property is './code");
        $this->assertEquals(false, $config->isDefaultConfiguration(), "config is not using the default configuration");
        $this->assertEquals("answers", $config->getAnswerDir(), "answerDir is answers");
        $this->assertEquals("tests", $config->getProofDir(), "proofDir is tests");
        $this->assertEquals(true, $config->isSuppressCodingConventionErrors(), "Suppress Coding Convention errors is set to true");
        $this->assertEquals(true, $config->isSuppressMessDetectionErrors(), "Suppress Mess Detection errors is set to true");
        $this->assertEquals(false, $config->isSandboxMode(), "Sandbox mode is false if we set the env variable");
    }

    public static function tearDownAfterClass()
    {
        putenv("PROOF_LIBRARY_MODE");
        unlink("./proof.json");
    }    
}
