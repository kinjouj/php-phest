<?php
    require_once dirname(__FILE__).'/Phest/Assert/Plan.php';
    require_once dirname(__FILE__).'/Phest/Assert/That.php';
    require_once dirname(__FILE__).'/Phest/Exception.php';
    require_once dirname(__FILE__).'/Phest/Matcher.php';
    require_once dirname(__FILE__).'/Phest/Subtest.php';

    define("VERSION", "0.1");

    class Phest {
        public static function getVersion() {
            return VERSION;
        }
    }

    function plan($value) {
        return Phest_Assert_Plan::evaluate($value, null);
    }

    function assertThat($value, Phest_Matcher $assert) {
        return Phest_Assert_That::evaluate($value, $assert);
    }

    function is($value) {
        return new Phest_Matcher(
            function ($expect) use($value) {
                if (is_array($expect)) {
                    $expect = reset($expect);
                }

                if ($value !== $expect) {
                    throw new Phest_Exception("got $expect !== actual $value");
                }

                return true;
            }
        );
    }

    function nullValue() {
        return new Phest_Matcher(
            function($value) {
                if (is_array($value)) {
                    $value = reset($value);
                }

                if (!is_null($value)) {
                    throw new Phest_Exception("value isn`t a null");
                }

                return true;
            }
        );
    }

    function notNullValue() {
        return new Phest_Matcher(
            function($value) {
                if (is_array($value)) {
                    $value = reset($value);
                }

                if (is_null($value)) {
                    throw new Phest_Exception("value is null");
                }

                return true;
            }
        );
    }
?>
