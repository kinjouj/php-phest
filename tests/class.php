<?php
    class Phest_Assert_Dummy extends Phest_Assert {
        public static function evaluate($expectedValue, Phest_Matcher $matcher) {
        }
    }

    class NoColor {
        public function convert($s) {
            return $s;
        }
    }
