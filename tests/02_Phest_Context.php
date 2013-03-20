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

        public function test_run() {
            $instance = Phest_Context::getInstance();
            $this->assertNotNull($instance);
            $this->assertFalse($instance->run(null));
            $this->assertFalse($instance->run('dummy.php'));

            $dummy = dirname(__FILE__).'/dummy.php';

            $this->assertOutput(
                function() use($dummy, $instance) {
                    file_put_contents($dummy, '<?php ?>');

                    $this->assertTrue($instance->run($dummy));

                    if (file_exists($dummy)) {
                        unlink($dummy);
                    }
                },
                function($output) use($dummy) {
                    $this->assertThat($output, $this->equalTo("--- $dummy"));
                }
            );
        }

        public function test_getReporter() {
            $this->callClosure(
                function() {
                    $instance = Phest_Context::getInstance();
                    $this->assertNotNull($instance);
                    $this->assertInstanceOf('Phest_Report', $instance->getReporter());

                    $this->setExpectedException('Phest_Exception', 'reporter isn`t a instanceof Phest_Report');
                    $instance->reporter = null;
                    $instance->getReporter();
                },
                'Phest_Context'
            );
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
            $this->callClosure(
                function() {
                    $instance = Phest_Context::getInstance();
                    $this->assertEmpty($instance->getSubtests());

                    $instance->subtests = null;

                    $this->setExpectedException('Phest_Exception', 'subtests isn`t a array');
                    $instance->getSubtests();
                },
                'Phest_Context'
            );
        }

        public function test_addSubtest() {
            $this->callClosure(
                function() {
                    $instance1 = Phest_Context::getInstance();
                    $this->assertNotNull($instance1);
                    $this->assertEmpty($instance1->subtests);

                    $instance2 = Phest_Context::newInstance();
                    $this->assertNotSame($instance1, $instance2);

                    $instance1->addSubtest($instance2);
                    $this->assertCount(1, $instance1->subtests);
                },
                'Phest_Context'
            );
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
