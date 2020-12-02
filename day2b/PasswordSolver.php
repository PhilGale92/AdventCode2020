<?php
class PasswordSolver {
    private $_inputArray = [];
    private $_output = '';

    public function __construct($inputFileName = __DIR__ . '/input.txt'){
        $this->_import($inputFileName);
        $this->_solve();
    }
    private function _import($inputFileName){
        $fileC = file_get_contents($inputFileName);
        $this->_inputArray = explode("\r\n", $fileC);
    }

    private function _solve(){
        $regex = '#(\d+)-(\d+) (\D+): ([\w]+)#is';
        $this->_output = 0;
        foreach ($this->_inputArray as $passwordLine) {
            preg_match_all($regex, $passwordLine, $c);
            if (!empty($c) && !empty($c[1])){
                $lowerBound = $c[1][0];
                $upperBound = $c[2][0];
                $baseChar = $c[3][0];
                $password = $c[4][0];
                if ($this->_isPasswordValid($password, $baseChar, $lowerBound, $upperBound)){
                    $this->_output++;
                }
            }
        }
    }

    /**
     * @param $password string
     * @param $baseChar string
     * @param $lowerBound int
     * @param $upperBound int
     * @return bool
     */
    private function _isPasswordValid($password, $baseChar, $lowerBound, $upperBound){
        $lowerBound--;
        $upperBound--;
        if (!isset($password[$upperBound]))
            return false;
        if (
            ($password[$lowerBound] === $baseChar && $password[$upperBound] !== $baseChar) ||
            ($password[$upperBound] === $baseChar && $password[$lowerBound] !== $baseChar)
        ){
            return true;
        }
        return false;
    }
    public function __toString(){
        return (String) $this->_output;
    }
}