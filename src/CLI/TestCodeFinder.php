<?php

namespace CodingAvenue\Proof\CLI;

class TestCodeFinder
{
    private $baseTestAnswerDir;
    private $baseTestDir;

    public function __construct($answerDir = 'answers', $testDir = 'tests')
    {
        $this->baseTestAnswerDir = realpath($answerDir);
        $this->baseTestDir = realpath($testDir);
    }

    public function findTestCode(string $testFile)
    {
        $testFile = realpath($testFile);
        if (!file_exists($testFile)) {
            throw new \Exception("Cannot find file {$testFile}");
        }

        // This should remove the double // on the resulting path.
        $separator = DIRECTORY_SEPARATOR;
        $answerPath = str_replace("{$this->baseTestDir}{$separator}", '', $testFile);

        $answerFile = join($separator, array($this->baseTestAnswerDir, $answerPath));

        if (!file_exists($answerFile)) {
            throw new \Exception("Unable to find answer file {$answerFile}");
        }

        return $answerFile;
    }
}
