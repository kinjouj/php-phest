<?php
    require_once dirname(__FILE__).'/Context.php';
    require_once dirname(__FILE__).'/Exception.php';
    require_once dirname(__FILE__).'/Report.php';
    require_once dirname(__FILE__).'/Report/Console.php';

    class Phest_Context {

        private $reporter = null;
        private $testCount = 0;
        private $subtests = [];

        private static $instance;

        private function __construct() {
            $this->reporter = new Phest_Report_Console();
        }

        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::setInstance(new Phest_Context());
            }

            return self::$instance;
        }

        public static function newInstance() {
            self::setInstance(new Phest_Context());

            return self::$instance;
        }

        public static function setInstance(Phest_Context $instance) {
            self::$instance = $instance;
        }

        public function run($test) {
            if (is_null($test)) {
                return false;
            }

            if (!file_exists($test)) {
                return false;
            }

            $reporter = $this->getReporter();
            $reporter->write("--- {$test}\n");

            include $test;

            return true;
        }

        public function getReporter() {
            if (!($this->reporter instanceof Phest_Report)) {
                throw new Phest_Exception('reporter isn`t a instanceof Phest_Report');
            }

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

            self::$instance = null;
        }
    }
?>
