<?php
class Passport {
    private static $_props = [
        'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid', 'cid'
    ];
    private static $_require_props = [
        'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid',
    ];
    private static $_eyeColours = [
        'amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth'
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
            if ($this->{$requiredProp} === null) continue;
            $val = $this->{$requiredProp};
            $valLen = strlen($val);

            $bPropValid = false;
            switch ($requiredProp){
                case 'byr':
                    if (is_numeric($val) && $val >= 1920 && $val <= 2002){
                        $bPropValid = true;
                    }
                    break;
                case 'iyr':
                    if (is_numeric($val) && $val >= 2010 && $val <= 2020){
                        $bPropValid = true;
                    }
                    break;
                case 'eyr':
                    if (is_numeric($val) && $val >= 2020 && $val <= 2030){
                        $bPropValid = true;
                    }
                    break;
                case 'hgt':
                    $unit = substr($val, -2);
                    $hgtValue = substr($val, 0, -2);
                    if ($unit === 'in' && is_numeric($hgtValue) && $hgtValue >= 59 && $hgtValue <= 76) {
                        $bPropValid = true;
                    } else if ($unit === 'cm' && is_numeric($hgtValue) && $hgtValue >= 150 && $hgtValue <= 193) {
                        $bPropValid = true;
                    }
                    break;
                case 'hcl':
                    $firstChar = substr($val, 0, 1);
                    $remainder = substr($val, 1);
                    if ($firstChar === '#' && ctype_xdigit($remainder)){
                        $bPropValid = true;
                    }
                    break;
                case 'ecl':
                    if (in_array($val, self::$_eyeColours)) $bPropValid = true;
                    break;
                case 'pid':
                    if ($valLen === 9 && is_numeric($val)) $bPropValid = true;
                    break;
            }
            if ($bPropValid){
                $setRequireCount++;
            }
        }
        if ($setRequireCount == $reqCount){
            return true;
        }

        return false;
    }
}