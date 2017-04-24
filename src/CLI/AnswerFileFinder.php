<?php

namespace CodingAvenue\Proof\CLI;

/**
 * Answer file resolver class.
 * It determines what answer file to use against a given proof file. Allows user of the Code class to locally test their proof file.
 * The way it finds the file is to use the path of the path after the proof base directory
 * And append it to the answer base directory.
 */
class AnswerFileFinder
{
    private $baseAnswerDir;
    private $baseProofDir;

    /**
     * Constructor
     *
     * @param answerDir     string The base answer directory where all test code file can be found
     * @param proofDir      string The base proof directory
     */
    public function __construct($answerDir = 'answers', $proofDir = 'tests')
    {
        $this->baseAnswerDir = realpath($answerDir);
        $this->baseProofDir = realpath($proofDir);
    }

    /**
     * Returns the answer file for a given proof file
     * 
     * @param string $testFile The proof file
     * @return string the test code file that matched the proof file path after the test base directory.
     * @throws Exception if the answerFile does not exists.
     */
    public function resolve(string $testFile)
    {
        $testFile = realpath($testFile);
        if (!file_exists($testFile)) {
            throw new \Exception("Cannot find file {$testFile}");
        }

        // This should remove the double // on the resulting path.
        $separator = DIRECTORY_SEPARATOR;
        $answerPath = str_replace("{$this->baseProofDir}{$separator}", '', $testFile);

        $answerFile = join($separator, array($this->baseAnswerDir, $answerPath));

        if (!file_exists($answerFile)) {
            throw new \Exception("Unable to find answer file {$answerFile}");
        }

        return $answerFile;
    }
}
