<?php
    require_once dirname(__FILE__).'/Phest/Assert/That.php';
    require_once dirname(__FILE__).'/Phest/Assert/That/Is.php';
    require_once dirname(__FILE__).'/Phest/Subtest.php';

    define("VERSION", "0.01");

    class Phest {
        public static function getVersion() {
            return VERSION;
        }
    }
