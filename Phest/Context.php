<?php
    require_once dirname(__FILE__).'/Exception.php';
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
                self::setInstance(new Phest_Context());
            }

            return static::$instance;
        }

        public static function newInstance() {
            self::setInstance(new Phest_Context());

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

        public function &getSubtests() {
            if (!is_array($this->subtests)) {
                throw new Phest_Exception('subtests isn`t a array');
            }

            return $this->subtests;
        }

        public function addSubtest(Phest_Context $ctx) {
            $subtests = &$this->getSubtests();
            $subtests[] = $ctx;
        }

        public function getCountByAll() {
            $nums = $this->testCount;
            $subtests = $this->getSubtests();

            foreach ($subtests as $subtest) {
                $nums += $subtest->getCountByAll();
            }

            return $nums;
        }

        public function reset() {
            $this->testCount = 0;
            $this->subtests = [];
        }
    }
