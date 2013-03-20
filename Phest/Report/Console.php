<?php
    require_once dirname(__FILE__).'/../Exception.php';
    require_once dirname(__FILE__).'/../Report.php';
    require_once 'Console/Color2.php';

    class Phest_Report_Console extends Phest_Report {

        private $color;

        public function __construct() {
            $this->color = new Console_Color2();
        }

        public function write($text) {
            if (!($this->color instanceof Console_Color2)) {
                throw new Phest_Exception('color isn`t a instanceof Console_Color2');
            }

            if (empty($text)) {
                throw new Phest_Exception("text is empty");
            }

            echo $this->color->convert($text);
        }

        public function report(Phest_Exception $e = null, $line = 0) {
            return is_null($e) ? $this->report_pass() : $this->report_fail($e, $line);
        }

        private function report_pass() {
            echo $this->write("%b{$this->incrementCount()} OK%n"), "\r\n";

            return true;
        }

        private function report_fail(Phest_Exception $e, $line) {
            $this->write("%r{$this->incrementCount()} NOT OK ");
            $this->write("line:{$line} {$e->getMessage()}%n\r\n");

            return false;
        }

        private function incrementCount() {
            $tester = Phest_Context::getInstance();

            return $tester->incrementCount();
        }
    }
