<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Context_TestCase extends TestCase {

        public function test_construct() {
            $instance1 = Phest_Context::getInstance();
            $this->assertNotNull($instance1);

            $instance2 = Phest_Context::getInstance();
            $this->assertNotNull($instance2);

            $this->assertSame($instance1, $instance2);
        }

        public function test_newInstance() {
            $instance1 = Phest_Context::getInstance();
            $this->assertNotNull($instance1);

            $instance2 = Phest_Context::newInstance();
            $this->assertNotSame($instance1, $instance2);
        }

        public function test_runTest() {

        }

        public function test_getReporter() {
            $instance = Phest_Context::getInstance();
            $this->assertNotNull($instance);

            $this->assertTrue($instance->getReporter() instanceof Phest_Report);
        }

        public function test_getCount() {
            $instance = Phest_Context::getInstance();
            $this->assertNotNull($instance);

            $this->assertThat($instance->getCount(), $this->equalTo(0));
        }

        public function test_incrementCount() {
            $instance = Phest_Context::getInstance();
            $this->assertNotNull($instance);

            $this->assertThat($instance->incrementCount(), $this->equalTo(1));
        }

        public function test_getSubtests() {
            $cb = Closure::bind(
                function() {
                    $instance = Phest_Context::getInstance();
                    $this->assertEmpty($instance->getSubtests());

                    $instance->subtests = null;

                    $this->setExpectedException('Phest_Exception', 'subtests isn`t a array');
                    $instance->getSubtests();
                },
                $this,
                'Phest_Context'
            );
            $cb();
        }

        public function test_addSubtest() {
            $cb = Closure::bind(
                function() {
                    $instance1 = Phest_Context::getInstance();
                    $this->assertNotNull($instance1);
                    $this->assertEmpty($instance1->subtests);

                    $instance2 = Phest_Context::newInstance();
                    $this->assertNotSame($instance1, $instance2);

                    $instance1->addSubtest($instance2);
                    $this->assertCount(1, $instance1->subtests);
                },
                $this,
                'Phest_Context'
            );
            $cb();
        }

        public function test_getCountByAll() {
            $instance1 = Phest_Context::getInstance();
            $this->assertNotNull($instance1);
            $this->assertThat($instance1->incrementCount(), $this->equalTo(1));

            $instance2 = Phest_Context::newInstance();
            $this->assertNotNull($instance2);
            $this->assertThat($instance2->incrementCount(), $this->equalTo(1));

            $instance1->addSubtest($instance2);

            $this->assertThat($instance1->getCountByAll(), $this->equalTo(2));
        }

        public function test_reset() {
            $instance = Phest_Context::getInstance();
            $this->assertNotNull($instance);

            $this->assertThat($instance->incrementCount(), $this->equalTo(1));
            $this->assertThat($instance->getCountByAll(), $this->equalTo(1));

            $instance->reset();

            $this->assertThat($instance->getCountByAll(), $this->equalTo(0));
        }
    }
?>
