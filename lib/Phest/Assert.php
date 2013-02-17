<?php
    require_once dirname(__FILE__).'/../Phest.php';
    require_once dirname(__FILE__).'/Exception.php';

    interface Phest_Assert_Interface {
        static function evaluate($value, $assert);
    }

    abstract class Phest_Assert implements Phest_Assert_Interface {
        public static function getTester() {
            return Phest::getInstance();
        }

        public static function report($testSuccessful, Phest_Exception $e = NULL) {
            self::getTester()->getReporter()->report($testSuccessful, $e);
        }
    }
