<?php
    require_once dirname(__FILE__).'/../Assert.php';

    class Phest_Assert_Plan extends Phest_Assert {
        public static function evaluate($value, Phest_Matcher $matcher = null) {
            try {
                if (!is_int($value)) {
                    throw new Phest_Exception('value isn`t int');
                }

                $testCount = static::getTester()->getCount();

                if ($testCount === $value) {
                    return static::report();
                } else {
                    throw new Phest_Exception("plan got $testCount !== expected $value");
                }
            } catch (RuntimeException $e) {
                return static::report(
                    new Phest_Exception($e->getMessage()),
                    static::getLine('plan')
                );
            }
        }
    }
