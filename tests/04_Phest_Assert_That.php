<?php
    require_once 'Phest/Assert/That.php';

    class Phest_Assert_That_TestCase extends PHPUnit_Framework_TestCase {
        public function test_assertThat() {
            assertThat('A', is('A'));

            try {
                assertThat('A', is('B'));
            } catch (Phest_Exception $e) {
                //$this->assertThat($e->getMessage(), $this->equalTo('got A !== actual B'));
            }
        }
    }
