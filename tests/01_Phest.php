<?php
    require_once 'Phest.php';

    class Phest_TestCase extends PHPUnit_Framework_TestCase {

        public function test_getInstance() {
            $obj1 = Phest::getInstance();
            $this->assertNotNull($obj1);

            $obj2 = Phest::getInstance();
            $this->assertNotNull($obj2);
            $this->assertTrue($obj1 === $obj2);
        }
    }
