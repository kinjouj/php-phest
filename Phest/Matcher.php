<?php
    class Phest_Matcher {

        private $evaluator;

        public function __construct(callable $evaluator) {
            $this->evaluator = $evaluator;
        }

        public function evaluate() {
            $evaluator = $this->evaluator;

            return $evaluator(func_get_args());
        }
    }
