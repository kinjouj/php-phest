<?php
    require_once dirname(__FILE__).'/../Assert.php';
    require_once dirname(__FILE__).'/../Exception.php';
    require_once dirname(__FILE__).'/../Matcher.php';

    class Phest_Assert_Plan extends Phest_Assert {
        public static function evaluate($value, Phest_Matcher $matcher = null) {
            try {
                if (!is_int($value)) {
                    throw new Phest_Exception('value isn`t int');
                }

                $testCount = self::getTester()->getCount();

                if ($testCount === $value) {
                    return self::report();
                } else {
                    throw new Phest_Exception("plan got $testCount !== expected $value");
                }
            } catch (RuntimeException $e) {
                return self::report(
                    new Phest_Exception($e->getMessage()),
                    self::getLine('plan')
                );
            }
        }
    }
?>
