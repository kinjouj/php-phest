<?php
    require_once dirname(__FILE__).'/Exception.php';

    abstract class Phest_Report {
        abstract function write($str);
        abstract function report(Phest_Exception $e = null, $line = 0);
    }
