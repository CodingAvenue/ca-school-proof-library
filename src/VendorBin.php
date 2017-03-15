<?php

namespace CodingAvenue\Proof;

class VendorBin {
    public static function getBinPath()
    {
        return dirname(__FILE__) . "/../../../bin/";
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
