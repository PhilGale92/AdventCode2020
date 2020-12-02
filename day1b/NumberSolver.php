<?php
    class NumberSolver {
        private $_targetNumber = null;
        private $_inputArray = [];
        private $_output = '';

        public function __construct($targetNumber, $inputFileName = __DIR__ . '/input.txt'){
            $this->_targetNumber = $targetNumber;
            $this->_import($inputFileName);
            $this->_solve();
        }
        private function _import($inputFileName){
            $fileC = file_get_contents($inputFileName);
            $this->_inputArray = explode("\r\n", $fileC);
        }

        private function _solve(){
            $matchedNumbers = [];
            foreach ($this->_inputArray as $number){
                foreach ($this->_inputArray as $number2){
                    foreach ($this->_inputArray as $number3){
                        if ((int) $number + (int) $number2 + (int) $number3 === 2020){
                            $matchedNumbers[] = $number;
                            $matchedNumbers[] = $number2;
                            $matchedNumbers[] = $number3;
                            break 3;
                        }
                    }
                }
            }
            $this->_output = (string) array_product($matchedNumbers);
        }

        public function __toString(){
            return $this->_output;
        }
    }