<?php
    require_once dirname(__FILE__).'/Report/Console.php';

    class Phest_Context {

        private $reporter = null;
        private $testCount = 0;
        private $subtests = [];

        private static $instance;

        private function __construct() {
            $this->reporter = new Phest_Report_Console($this);
        }

        public static function getInstance() {
            if (is_null(static::$instance)) {
                static::$instance = new Phest_Context();
            }

            return static::$instance;
        }

        public static function newInstance($isSubtest = false) {
            static::$instance = new Phest_Context();


            return static::$instance;
        }

        public static function setInstance(Phest_Context $instance) {
            static::$instance = $instance;
        }

        public function run($test) {
            if (is_null($test)) {
                return;
            }

            if (!file_exists($test)) {
                return;
            }

            $reporter = $this->getReporter();
            $reporter->write("--- {$test}\n");

            include $test;
        }

        public function getReporter() {
            return $this->reporter;
        }

        public function getCount() {
            return $this->testCount;
        }

        public function incrementCount() {
            return ++$this->testCount;
        }

        public function addSubtest($ctx) {
            $this->subtests[] = $ctx;
        }

        public function getCountByAll() {
            $nums = $this->testCount;

            foreach ($this->subtests as $subtest) {
                $nums += $this->getCountBySubtest($subtest);
            }

            return $nums;
        }

        public function getCountBySubtest($testContext) {
            $nums = $testContext->testCount;

            foreach ($testContext->subtests as $subtest) {
                $nums += $this->getCountBySubtest($subtest);
            }

            return $nums;
        }

        public function reset() {
            $this->testCount = 0;
            $this->subtests = [];
        }
    }
