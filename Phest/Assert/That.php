<?php
    require_once dirname(__FILE__).'/../Assert.php';
    require_once dirname(__FILE__).'/../Matcher.php';

    class Phest_Assert_That extends Phest_Assert {
        public static function evaluate($value, Phest_Matcher $matcher) {
            try {
                $matcher->evaluate($value);

                return self::report();
            } catch (RuntimeException $e) {
                return self::report(
                    new Phest_Exception($e->getMessage()),
                    self::getLine("assertThat")
                );
            }
        }
    }
?>
