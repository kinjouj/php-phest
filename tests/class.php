<?php
    require_once 'Phest.php';
    require_once 'Console/Color2.php';

    abstract class TestCase extends PHPUnit_Framework_TestCase {

        private $color;

        public function setUp() {
            $this->color = new Console_Color2();
        }

        public function tearDown() {
            Phest_Context::getInstance()->reset();
        }

        public function assertOutput($inCallback, $outCallback) {
            ob_start();
            $inCallback();
            $output = ob_get_contents();
            $output = $this->color->strip($output);
            ob_end_clean();

            $outCallback(trim($output, "\r\n"));
        }

        public function callClosure($cb, $class) {
            $cb  = Closure::bind($cb, $this, $class);
            $cb();
        }
    }

    class Phest_Assert_Dummy extends Phest_Assert {
        public static function evaluate($expectedValue, Phest_Matcher $matcher) {
        }
    }
?>
