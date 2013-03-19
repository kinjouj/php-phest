<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Assert_That_TestCase extends TestCase {

        public function setUp() {
            $cb = Closure::bind(
                function() {
                    Phest_Assert_That::getTester()->testCount = 1;
                },
                $this,
                'Phest_Context'
            );
        }

        public function test_assertThat_pass() {
            $cb = Closure::bind(
                function() {
                    Phest_Assert_That::getReporter()->color = new NoColor();

                    $this->assertTrue(assertThat('A', is('A')));
                },
                $this,
                'Phest_Report_Console'
            );
            $cb();
        }

        public function test_assertThat_fail() {
            $cb = Closure::bind(
                function() {
                    Phest_Assert_That::getReporter()->color = new NoColor();

                    $this->assertFalse(assertThat('A', is('B')));
                },
                $this,
                'Phest_Report_Console'
            );
            $cb();
        }
    }
