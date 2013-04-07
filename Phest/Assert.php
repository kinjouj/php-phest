<?php
    require_once dirname(__FILE__).'/Context.php';
    require_once dirname(__FILE__).'/Matcher.php';
    require_once dirname(__FILE__).'/Report.php';

    interface Phest_Assert_Interface {
        static function evaluate($value, Phest_Matcher $matcher);
    }

    abstract class Phest_Assert implements Phest_Assert_Interface {

        public static function getTester() {
            return Phest_Context::getInstance();
        }

        public static function getReporter() {
            $tester = self::getTester();

            if ($tester instanceof Phest_Context) {
                $reporter = $tester->getReporter();

                if ($reporter instanceof Phest_Report) {
                    return $reporter;
                }
            }

            return null;
        }

        public static function report(Phest_Exception $e = null, $line = 0) {
            $reporter = self::getReporter();

            if (is_null($reporter)) {
                throw new Phest_Exception('reporter is null');
            }

            return $reporter->report($e, $line);
        }

        public static function getLine($func_name, array $traces = []) {
            if (empty($func_name)) {
                throw new Phest_Exception('func_name is empty');
            }

            if (empty($traces)) {
                $traces = debug_backtrace();
            }

            return array_reduce(
                $traces,
                function($a, $b) use($func_name) {
                    if (isset($b['function'])) {
                        if ($b['function'] === $func_name) {
                            if (isset($b['line'])) {
                                $a = $b['line'];
                            }
                        }
                    }

                    return $a;
                },
                0
            );
        }
    }
?>
