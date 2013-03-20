<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Assert_TestCase extends TestCase {

        public function test_getTester() {
            $this->assertInstanceOf('Phest_Context', Phest_Assert_Dummy::getTester());
        }

        public function test_getReporter_pass() {
            $this->assertInstanceOf('Phest_Report', Phest_Assert_Dummy::getReporter());
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

            $mock::getReporter(); //thrown
        }

        public function test_report() {
            $this->assertOutput(
                function() {
                    $assert = new Phest_Assert_Dummy();
                    $assert->report();
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('1 OK'));
                }
            );
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
                    array(array('function' => 'assertThat', 'line' => 30))
                ),
                $this->equalTo(30)
            );
        }
    }
