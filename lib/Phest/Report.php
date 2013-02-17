<?php
    class Phest_Report {

        private $message;

        public function __construct($message) {
            $this->message = $message;
        }

        public function getMessage() {
            return $this->message;
        }
    }
