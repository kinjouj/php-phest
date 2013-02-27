<?php
    require_once 'Phest.php';

    class Phest_TestCase extends PHPUnit_Framework_TestCase {
        public function test_phest_version() {
            $this->assertThat(Phest::getVersion(), $this->equalTo("0.01"));
        }
    }
