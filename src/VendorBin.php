<?php

namespace CodingAvenue\Proof;

class VendorBin {
    public static function getBinPath()
    {
        if (file_exists(dirname(__FILE__) . "/../../../bin")) {
            // proof-library is part of a composer installation.
            return dirname(__FILE__) . "/../../../bin/";
        }

        return dirname(__FILE__) . "/../vendor/bin/";
    }

    public static function getCS()
    {
        return self::getBinPath() . "phpcs";
    }

    public static function getMD()
    {
        return self::getBinPath() . "phpmd";
    }
}
