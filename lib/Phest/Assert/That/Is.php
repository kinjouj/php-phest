<?php
    require_once dirname(__FILE__).'/../../Assert.php';

    class Phest_Assert_That_Is extends Phest_Assert {

        private static $actualValue = NULL;

        public function __construct($value) {
            static::$actualValue = $value;
        }

        public static function evaluate($value, $assert  = NULL) {
            if (is_null($value)) {
                throw new Phest_Exception('excepted is null');
            }

            $actual = static::$actualValue;

            if (is_null($value)) {
                throw new Phest_Exception('actual is null');
            }

            if (static::$actualValue !== $value) {
                throw new Phest_Exception("got $value !== actual $actual");
            }

            return true;
        }
    }

    function is($value) {
        return new Phest_Assert_That_Is($value);
    }
