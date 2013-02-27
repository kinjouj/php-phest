<?php
    require_once dirname(__FILE__).'/../Assert.php';

    class Phest_Assert_That extends Phest_Assert {
        public static function evaluate($value, $assert) {
            self::_evaluate($value, $assert);
        }

        private static function _evaluate($value, Phest_Assert $assert = NULL) {
            try {
                $assert->evaluate($value, NULL);

                parent::report(true);
            } catch (Phest_Exception $e) {
                parent::report(false, $e);
            }
        }
    }

    function assertThat($value, $assert) {
        Phest_Assert_That::evaluate($value, $assert);
    }
