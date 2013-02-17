<?php
    require_once 'Console/Color2.php';

    class Phest_Report_Console {

        private $color;
        private $testCount;

        public function __construct() {
            $this->color = new Console_Color2();
        }

        public function report($testSuccessful, Phest_Exception $e = NULL) {
            $this->testCount++;

            if ($testSuccessful === true) {
                print $this->color->convert("%bOK {$this->testCount}")."\n";
            } else {
                print $this->color->convert("%rNOT OK {$this->testCount}")."\n";

                if (!is_null($e)) {
                    print "\t".$e->getMessage()."\n";
                }
            }
        }
    }
