<?php
    require_once dirname(__FILE__).'/Phest/Report/Console.php';

    class Phest {

        private static $instance = NULL;

        private $reporter;

        public static function getInstance() {
            if (is_null(static::$instance)) {
                static::$instance = new Phest();
            }

            return static::$instance;
        }

        private function __construct() {
            $this->reporter = new Phest_Report_Console();
        }

        public function getReporter() {
            return $this->reporter;
        }
    }
