<?php
    interface Phest_Assert_Interface {
        static function evaluate($value, $assert);
    }

    abstract class Phest_Assert implements Phest_Assert_Interface {
        public static function getTester() {
            return Phest_Context::getInstance();
        }

        public static function report($testSuccessful, $e = NULL) {
            static::getTester()->getReporter()->report($testSuccessful, $e);
        }
    }
