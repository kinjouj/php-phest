<?php
    require_once 'Console/Color2.php';
    require_once 'Console/CommandLine.php';

    require_once dirname(__FILE__).'/Assert.php';
    require_once dirname(__FILE__).'/Assert/Plan.php';
    require_once dirname(__FILE__).'/Assert/That.php';
    require_once dirname(__FILE__).'/Context.php';
    require_once dirname(__FILE__).'/Exception.php';
    require_once dirname(__FILE__).'/Matcher.php';
    require_once dirname(__FILE__).'/Report.php';
    require_once dirname(__FILE__).'/Report/Console.php';
    require_once dirname(__FILE__).'/Runner/Console.php';
    require_once dirname(__FILE__).'/Subtest.php';

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

    function subtest($comment, callable $cb) {
        Phest_Subtest::runSubtest($comment, $cb);
    }
?>
