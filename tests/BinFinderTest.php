<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\BinFinder;
use CodingAvenue\Proof\Config;

class BinFinderTest extends TestCase
{
    protected static $binFinder;

    public static function setUpBeforeClass()
    {
        $config = new Config();
        self::$binFinder = new BinFinder($config);
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(BinFinder::class, self::$binFinder, "\$binFinder is an instance of the BinFinder class");
    }

    public function testDefaultBin()
    {
        $defaultBin = self::$binFinder->getDefaultBinPath();

        $this->assertEquals("/home/tenshilyle/proof-library/src/../vendor/bin", $defaultBin, "The default bin path");
    }

    public function testGetCS()
    {
        $cs = self::$binFinder->getCS();
        $cwd = getcwd();

        $this->assertEquals("{$cwd}/vendor/bin/phpcs", $cs, "The Code Sniffer binary path");
    }

    public function testGetMD()
    {
        $md = self::$binFinder->getMD();
        $cwd = getcwd();

        $this->assertEquals("{$cwd}/vendor/bin/phpmd", $md, "The Mess Detection binary path");
    }

    public function testGetPHPUnit()
    {
        $phpunit = self::$binFinder->getPHPUnit();
        $cwd = getcwd();

        $this->assertEquals("{$cwd}/vendor/bin/phpunit", $phpunit, "The PHPUnit binary path");
    }
}
