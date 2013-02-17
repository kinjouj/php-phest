<?php
    require_once 'Phest/Assert/That/Is.php';

    class Phest_Assert_Is_TestCase extends PHPUnit_Framework_TestCase {

        public function test_class() {
            $cb = Closure::bind(
                function() {
                    $assert = new Phest_Assert_That_Is('A');
                    $this->assertNotNull($assert);
                    $this->assertThat($assert::$actualValue, $this->equalTo('A'));
                },
                $this,
                'Phest_Assert_That_Is'
            );
            $cb();
        }

        public function test_is() {
            $assert = is('A');
            $this->assertNotNull($assert);

            $this->assertTrue($assert->evaluate('A'));

            try {
                $assert->evaluate('B');
            } catch (Exception $e) {
                $this->assertTrue($e instanceof Phest_Exception);
            }
        }
    }
