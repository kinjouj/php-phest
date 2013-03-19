<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Assert_TestCase extends TestCase {

        public function test_getTester() {
            $this->assertTrue(
                Phest_Assert_Dummy::getTester() instanceof Phest_Context
            );
        }

        public function test_getReporter_pass() {
            $this->assertTrue(
                Phest_Assert_Dummy::getReporter() instanceof Phest_Report
            );
        }

        public function test_getReporter_getTester_is_null() {
            $mock = $this->getMock('Phest_Assert_Dummy', array('getTester'));
            $mock->staticExpects(
                $this->any()
            )->method(
                'getTester'
            )->will(
                $this->returnValue(null)
            );

            $mock::getReporter();
        }

        public function test_getReporter_getTester_call_getReporter_is_null() {
            $ctxMock = $this->getMockBuilder(
                'Phest_Context',
                array('getReporter')
            )->disableOriginalConstructor()->getMock();

            $ctxMock->expects(
                $this->any()
            )->method(
                'getReporter'
            )->will($this->returnValue(null));

            $mock = $this->getMock('Phest_Assert_Dummy', array('getTester'));
            $mock->staticExpects(
                $this->any()
            )->method(
                'getTester'
            )->will(
                $this->returnValue($ctxMock)
            );

            $mock::getReporter();
        }

        public function test_report() {
            $cb = Closure::bind(
                function() {
                    $assert = new Phest_Assert_Dummy();
                    $assert->getTester()->getReporter()->color = new NoColor();

                    $this->expectOutputString("%b1 OK%n\r\n");
                    $assert->report();
                },
                $this,
                'Phest_Report_Console'
            );
            $cb();
        }

        public function test_getLine() {
            try {
                Phest_Assert_Dummy::getLine('');
            } catch (Phest_Exception $e) {
                $this->assertThat(
                    $e->getMessage(),
                    $this->equalTo('func_name is empty')
                );
            }

            $this->assertThat(
                Phest_Assert_Dummy::getLine('assertThat'),
                $this->equalTo(0)
            );

            $this->assertThat(
                Phest_Assert_Dummy::getLine(
                    'assertThat',
                    array(
                        array('function' => 'assertThat', 'line' => 30)
                    )
                ),
                $this->equalTo(30)
            );
        }
    }
