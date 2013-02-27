<?php
    abstract class Phest_Report {
        abstract function __construct($tester);
        abstract function write($str);
    }
