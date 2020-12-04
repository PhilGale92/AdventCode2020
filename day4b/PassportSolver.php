<?php
class PassportSolver {
    private $_inputArray = [];
    private $_output = '';
    public function __construct(){
        $this->_import();

    }

    private function _import(){
        $raw = explode("\r\n", file_get_contents(__DIR__ . '/input.txt'));
        $chunks = [];
        $passports = [];
        foreach ($raw as $line){
            if (!empty(trim($line))){
                $chunks[] = $line;
                continue;
            }
            $passports[] = new Passport($chunks);
            $chunks = []; // blank out the chunks!
        }
        $this->_output = 0;
        foreach ($passports as $passport){
            if ($passport->isValid()) $this->_output++;
        }
    }

    public function __toString(){
        return (string) $this->_output;
    }


}