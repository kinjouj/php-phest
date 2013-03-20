<?php
    class Phest_Matcher_TestCase extends TestCase {

        public function test_evaluate() {
            $matcher = new Phest_Matcher(function() { return true; });
            $this->assertNotNull($matcher);
            $this->assertTrue($matcher->evaluate());
        }

        public function test_evaluate_evaluator_is_null() {
            $matcher = new Phest_Matcher(function() {});

            $this->callClosure(
                function() use($matcher) {
                    $this->setExpectedException('Phest_Exception', 'evaluator isn`t a callable');
                    $matcher->evaluator = null;
                    $matcher->evaluate();
                },
                'Phest_Matcher'
            );
        }

        public function test_evaluate_evaluator_response_isnt_bool() {
            $this->setExpectedException('Phest_Exception', 'evaluator response isn`t a bool');
            $matcher = new Phest_Matcher(function() {});
            $matcher->evaluate();
        }
    }
