<?php

namespace CodingAvenue\Proof;

class Config
{
    private $codeFilePath;
    private $verbose = false;
    private $testAnswerDir;
    private $testDir;
    private $defaultConfiguration;

    private $defaultSettings = array(
        "codeFilePath" => "/code",
        "verbose" => false,
        "testAnswerDir" => "answers",
        "testDir" => "tests",
        "defaultConfiguration" => false
    );

    /**
     * Create an instance to Config class
     * The default settings will be used and can be overwritten by creating a proof.json file
     * at the current working directory.
     */
    public function __construct()
    {
        $configFile = getenv("PROOF_LIBRARY_MODE") === 'default' ? realpath("proof.json") : null;

        if ($configFile && file_exists($configFile)) {
            $config = json_decode(file_get_contents($configFile), true);
            $config = array_merge($this->defaultSettings, $config);
            $this->loadConfiguration($config);
        }
        else {
            $config = $this->defaultSettings;
            $config['defaultConfiguration'] = true;

            $this->loadConfiguration($config);
        }
    }

    public function loadConfiguration($config)
    {
        $this->codeFilePath = $config['codeFilePath'];
        $this->verbose = $config['verbose'];
        $this->testAnswerDir = $config['testAnswerDir'];
        $this->testDir = $config['testDir'];
        $this->defaultConfiguration = $config['defaultConfiguration'];
    }

    public function getCodeFilePath()
    {
        return $this->codeFilePath;
    }

    public function getVerbose()
    {
        return $this->verbose;
    }

    public function getTestAnswerDir()
    {
        return $this->testAnswerDir;
    }

    public function getTestDir()
    {
        return $this->testDir;
    }

    public function isDefaultConfiguration()
    {
        return $this->defaultConfiguration;
    }
}
