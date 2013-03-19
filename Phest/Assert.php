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
            $tester = static::getTester();

            if (!($tester instanceof Phest_Context)) {
                return null;
            }

            $reporter = $tester->getReporter();

            if (!($reporter instanceof Phest_Report)) {
                return null;
            }

            return $reporter;
        }

        public static function report(Phest_Exception $e = null, $line = 0) {
            return static::getReporter()->report($e, $line);
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
                    if (isset($b['function']) && $b['function'] === $func_name) {

                        if (isset($b['line'])) {
                            $a = $b['line'];
                        }
                    }

                    return $a;
                },
                0
            );
        }
    }
