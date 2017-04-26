<?php

namespace CodingAvenue\Proof;

class VendorBin {
    /**
     * VendorBin static class. Gives us a cross platform path to the binary installed by composer.
     */
    public static function getBinPath()
    {
        if (file_exists(implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "..", "..", "bin")))) {
            // proof-library is part of a composer installation.
            //bin directory from the VendorBin directory is at ../../../bin if we're part of a composer installation
            return implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "..", "..", "bin"));
        }

        // If we're not part of a composer installation then the vendor bin path at ../vendor/bin
        return implode(DIRECTORY_SEPARATOR, array(__DIR__, "..", "vendor", "bin"));
    }

    public static function getBin(string $bin)
    {
        return implode(DIRECTORY_SEPARATOR, array(self::getBinPath(), $bin));
    }

    public static function getCS()
    {
        return self::getBin("phpcs");
    }

    public static function getMD()
    {
        return self::getBin("phpmd");
    }

    public static function getPHPUnit()
    {
        return self::getBin("phpunit");
    }
}
