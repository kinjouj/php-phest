<?php
    require_once dirname(__FILE__).'/Report/Console.php';

    class Phest_Context {

        private $reporter = null;
        private $subtests = [];
        private $testCount = 0;

        private static $instance;

        private function __construct() {
            $this->reporter = new Phest_Report_Console($this);
        }

        public static function getInstance() {
            if (is_null(static::$instance)) {
                static::newInstance();
            }

            return static::$instance;
        }

        public static function newInstance() {
            static::$instance = new Phest_Context();

            return static::$instance;
        }

        public function run($test) {
            if (is_null($test)) {
                return;
            }

            if (!file_exists($test)) {
                return;
            }

            $reporter = $this->getReporter();
            $reporter->write("--- {$test}");

            ob_start();
            include $test;
            $testDetail = ob_get_contents();
            ob_end_clean();

            $reporter->write("1..{$this->getCount()}");
            $reporter->write($testDetail);
        }

        public function getReporter() {
            return $this->reporter;
        }

        public function increment() {
            $this->testCount++;
        }

        public function getCount() {
            $subtestCount = array_reduce(
                $this->subtests,
                function ($x, $y) {
                    return $y->getCount();
                }
            );

            return $this->testCount + $subtestCount;
        }

        public function addSubtest($ctx) {
            $this->subtests[] = $ctx;
        }
    }
