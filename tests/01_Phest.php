<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_TestCase extends TestCase {

        public function test_phest_version() {
            $this->assertThat(Phest::getVersion(), $this->equalTo('0.1'));
        }

        public function test_function_plan() {
            $this->assertTrue(function_exists('plan'));

            $this->assertOutput(
                function() {
                    $this->assertTrue(plan(0));
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('1 OK'));
                }
            );
        }

        public function test_function_assertThat() {
            $this->assertTrue(function_exists('assertThat'));

            $this->assertOutput(
                function() {
                    $this->assertTrue(assertThat(null, nullValue()));
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('1 OK'));
                }
            );
        }

        public function test_function_is() {
            $this->assertTrue(function_exists('is'));

            $matcher = is('hoge');
            $this->assertTrue($matcher->evaluate('hoge'));

            $this->setExpectedException('Phest_Exception', 'got fuga !== actual hoge');
            $matcher->evaluate('fuga');
        }

        public function test_function_nullValue() {
            $this->assertTrue(function_exists('nullValue'));

            $matcher = nullValue();
            $this->assertTrue($matcher->evaluate(null));

            $this->setExpectedException('Phest_Exception', 'value isn`t a null');
            $matcher->evaluate(new stdClass);
        }

        public function test_function_notNullValue() {
            $this->assertTrue(function_exists('notNullValue'));

            $matcher = notNullValue();
            $this->assertTrue($matcher->evaluate(new stdClass));

            $this->setExpectedException('Phest_Exception', 'value is null');
            $matcher->evaluate(null);
        }
    }
