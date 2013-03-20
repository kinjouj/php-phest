<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Assert_That_TestCase extends TestCase {

        public function test_assertThat_pass() {
            $this->assertOutput(
                function() {
                    $this->assertTrue(assertThat('A', is('A')));
                },
                function($output) {

                }
            );
        }

        public function test_assertThat_fail() {
            $this->assertOutput(
                function() {
                    $this->assertFalse(assertThat('A', is('B')));
                },
                function($output) {

                }
            );
        }
    }
