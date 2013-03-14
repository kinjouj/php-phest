<?php
    require_once dirname(__FILE__)."/Matcher.php";

    abstract class Phest_Report {
        abstract function __construct($tester);
        abstract function write($str);
    }
