<?php
    require_once dirname(__FILE__).'/class.php';

    require_once 'Phest.php';
    require_once 'Phest/Context.php';
    require_once 'Phest/Assert.php';
    require_once 'Phest/Exception.php';


    class Phest_Assert_Dummy extends Phest_Assert {
        public static function evaluate($value, $assert) {
        }
    }

    class Phest_Assert_TestCase extends PHPUnit_Framework_TestCase {

        public function test_getTester() {
            $this->assertNotNull(Phest_Assert_Dummy::getTester());
        }

        public function test_report() {
            $cb = Closure::bind(
                function() {
                    $assert = new Phest_Assert_Dummy();
                    $assert->getTester()->getReporter()->color = new Dummy_Coloring();

                    $this->expectOutputString("%b1 OK%n\n");
                    $assert->report(true);
                },
                $this,
                'Phest_Report_Console'
            );
            $cb();
        }
    }
