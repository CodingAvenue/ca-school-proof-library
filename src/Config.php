<?php

namespace CodingAvenue\Proof;

class Config
{
    private $codeFilePath;
    private $verbose = false;
    private $testAnswerDir;
    private $testDir;
    private $defaultConfiguration;

    /**
     * Create an instance to Config class, accepts an optional config file. Default to proof.json
     */
    public function __construct($configFile = null)
    {
        if (is_null($configFile)) {
            $configFile = realpath("proof.json");
        }

        if (!file_exists($configFile)) {
            // This shouldn't happen
            throw new \Exception("Cannot find configuration file");
        }

        $this->readConfigFile($configFile);
    }

    public function readConfigFile(string $configFile)
    {
        $config = json_decode(file_get_contents($configFile), true);

        $this->codeFilePath = $config['codeFilePath'] ?: '/code';
        $this->verbose = isset($config['verbose']) ? $config['verbose'] : false;
        $this->answerDir = isset($config['testAnswerDir']) ? $config['testAnswerDir'] : 'answers';
        $this->testDir = isset($config['testDir']) ? $config['testDir'] : 'tests';
        $this->defaultConfiguration = isset($config['defaultConfiguration']) ? $config['defaultConfiguration'] : false;
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
