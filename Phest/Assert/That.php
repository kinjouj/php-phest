<?php
    require_once dirname(__FILE__).'/../Assert.php';
    require_once dirname(__FILE__).'/../Matcher.php';

    class Phest_Assert_That extends Phest_Assert {
        public static function evaluate($value, Phest_Matcher $assert) {
            try {
                $assert->evaluate($value);

                return static::report();
            } catch (Phest_Exception $e) {
                return static::report(
                    new Phest_Exception($e->getMessage()),
                    static::getLine("assertThat")
                );
            }
        }
    }
