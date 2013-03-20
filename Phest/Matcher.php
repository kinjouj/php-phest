<?php
    require_once dirname(__FILE__).'/Exception.php';

    class Phest_Matcher {

        private $evaluator;

        public function __construct(callable $evaluator) {
            $this->evaluator = $evaluator;
        }

        public function evaluate() {
            if (!is_callable($this->evaluator)) {
                throw new Phest_Exception('evaluator isn`t a callable');
            }

            $evaluator = $this->evaluator;
            $response = $evaluator(func_get_args());

            if (!is_bool($response)) {
                throw new Phest_Exception('evaluator response isn`t a bool');
            }

            return $response;
        }
    }
