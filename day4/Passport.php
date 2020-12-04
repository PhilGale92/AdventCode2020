<?php
class Passport {
    private static $_props = [
        'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid', 'cid'
    ];
    private static $_require_props = [
        'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid',
    ];

    private $byr = null;
    private $iyr = null;
    private $eyr = null;
    private $hgt = null;
    private $hcl = null;
    private $ecl = null;
    private $pid = null;
    private $cid = null;

    public function __construct($rawChunks){
        $this->_fromArray($rawChunks);
    }
    private function _fromArray($rawChunks){
        $parsedData = [];
        foreach ($rawChunks as $chunk){
            $splitByKey = explode(' ', $chunk);
            foreach ($splitByKey as $keyProp){
                $keyedArray = explode(':', $keyProp);
                $parsedData[$keyedArray[0]] = $keyedArray[1];
            }
        }
        foreach (self::$_props as $propName){
            if (isset($parsedData[$propName]))
                $this->{$propName} = $parsedData[$propName];
        }
    }
    public function isValid(){
        $setRequireCount = 0;
        $reqCount = count(self::$_require_props);
        foreach (self::$_require_props as $requiredProp){
            if ($this->{$requiredProp} !== null){
                $setRequireCount++;
            }
        }
        if ($setRequireCount == $reqCount){
            return true;
        }

        return false;
    }
}