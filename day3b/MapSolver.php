<?php
class MapSolver {
    private $_inputArray = [];
    private $_outputArray = [];
    private $_output = '';

    public function __construct($inputFileName = __DIR__ . '/input.txt'){
        $this->_import($inputFileName);
        $this->_solve(1, 1);
        $this->_solve(3, 1);
        $this->_solve(5, 1);
        $this->_solve(7, 1);
        $this->_solve(1, 2);
    }
    private function _import($inputFileName){
        $fileC = file_get_contents($inputFileName);
        $lines = explode("\r\n", $fileC);
        $this->_inputArray = [];
        foreach ($lines as $line) {
            $this->_inputArray[] = str_split($line);
        }
    }

    private function _solve($xPattern, $yPattern){
        $maxX = count($this->_inputArray[0]);
        $maxY = count($this->_inputArray);
        $xCoord = 1;
        $yCoord = 1;
        $iterationOutput = 0;

        while ($yCoord < $maxY) {
            $xCoord += $xPattern;
            $yCoord += $yPattern;
            if ($xCoord > $maxX){
                $xCoord -= $maxX;
            }
            if (!isset($this->_inputArray[$yCoord - 1][$xCoord - 1])){
                continue;
            }

            $pos = $this->_inputArray[$yCoord - 1][$xCoord - 1];
            if ($pos === '#'){
                // Tree!
                $iterationOutput++;
            }
        }

        $this->_outputArray[] = $iterationOutput;
    }

    public function __toString(){
        return (String) array_product($this->_outputArray);
    }
}