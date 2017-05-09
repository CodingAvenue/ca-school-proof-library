<?php

namespace CodingAvenue\Proof;

use CodingAvenue\Proof\Config;

/**
 * BinFinder class part of the Proof Library package
 * Allow components of the Proof Library, to find the binary script it needed.
 */
class BinFinder
{
    /** @var String $binPath the path to the vendor's bin directory of this installation */ 
    private $binPath;

    public function __construct(Config $config)
    {
        if (is_null($config->getBinPath())) {
            // Default bin installation
            $this->binPath = $this->getDefaultBinPath();
        }
        else {
            if (!file_exists(realpath($config->getBinPath()))) {
                throw new \Exception("Bin path {$config->getBinPath()} does not exists. Please set the correct path.");
                $this->binPath = realpath($config->getBinPath());
            }
            
            $this->binPath = realpath($config->getBinPath());
        }
    }

    /**
     * Returns the default path for bin directory 
     */
    public function getDefaultBinPath()
    {
        if (file_exists(implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "..", "..", "bin")))) {
            // proof-library is part of a composer installation.
            // bin directory from the src directory is at ../../../bin if we're part of a composer installation
            return implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "..", "..", "bin"));
        }

        // If we're not part of a composer installation then the vendor bin path at ../vendor/bin
        return implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "vendor", "bin"));
    }

    /**
     * Returns the path of a binary specified by $bin.
     * Throws an Exception if the binary cannot be found.
     *
     * @param string $bin The name of the binary file.
     */
    public function getBin(string $bin)
    {
        $binary = implode(DIRECTORY_SEPARATOR, array($this->binPath, $bin));
        if (file_exists($binary)) {
            return $binary;
        }
        elseif (file_exists(implode(DIRECTORY_SEPARATOR, array(__DIR__, "bin", $bin)))) {
            // We're not part of a composer installation and we need to call OUR binaries. Should only be used by eval-runner for now
            return implode(DIRECTORY_SEPARATOR, array(__DIR__, "bin", $bin));
        }

        throw new \Exception("Unknown binary {$bin}.");
    }

    /**
     * Returns the Code Sniffer binary
     */
    public function getCS()
    {
        return $this->getBin("phpcs");
    }

    /**
     * Returns the Mess Detection binary.
     */
    public function getMD()
    {
        return $this->getBin("phpmd");
    }

    /**
     * Returns the PHPUnit binary
     */
    public function getPHPUnit()
    {
        return $this->getBin("phpunit");
    }

    /**
     * Returns the EvalRunner binary
     */
    public function getEvalRunner()
    {
        return $this->getBin("eval-runner");
    }
}
