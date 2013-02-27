<?php
    require_once 'Console/Color2.php';
    require_once dirname(__FILE__).'/../Report.php';

    class Phest_Report_Console extends Phest_Report {

        private $tester;
        private $color;

        public function __construct($tester) {
            $this->tester = $tester;
            $this->color = new Console_Color2();
        }

        public function write($str) {
            echo $this->color($str), "\n";
        }

        public function report($testSuccessful, Phest_Exception $e = NULL) {
            $this->tester->increment();

            $testSuccessful === true ? $this->report_pass() : $this->report_fail($e);
        }

        private function report_pass() {
            echo $this->color("%b{$this->tester->getCount()} OK%n"), "\n";
        }

        private function report_fail(Phest_Exception $e) {
            if (is_null($e)) {
                throw new Phest_Exception('unknown error');
            }

            $this->color("%r{$this->tester->getCount()} NOT OK");
            $this->color("\tline:{$e->getLine()} {$e->getMessage()}%n");
        }

        private function color($str) {
            if (empty($str)) {
                throw new Phest_Exception('text is empty');
            }

            echo $this->color->convert($str);
        }
    }
