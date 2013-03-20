<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Report_Console_TestCase extends TestCase {
        public function test_construct() {
            $this->callClosure(
                function() {
                    $reporter = new Phest_Report_Console(
                        Phest_Context::getInstance()
                    );

                    $this->assertInstanceOf('Console_Color2', $reporter->color);
                },
                'Phest_Report_Console'
            );
        }

        public function test_write() {
            $this->callClosure(
                function() {
                    $reporter = new Phest_Report_Console();

                    $this->assertOutput(
                        function() use($reporter) {
                            $reporter->write('dummy');
                        },
                        function($output) {
                            $this->assertThat($output, $this->equalTo('dummy'));
                        }
                    );

                    try {
                        $reporter->write(null);
                    } catch (Phest_Exception $e) {
                        $this->assertThat(
                            $e->getMessage(),
                            $this->equalTo('text is empty')
                        );
                    }

                    try {
                        $reporter->color = null;
                        $reporter->write('dummy');
                    } catch (Phest_Exception $e) {
                        $this->assertThat(
                            $e->getMessage(),
                            $this->equalTo('color isn`t a instanceof Console_Color2')
                        );
                    }
                },
                'Phest_Report_Console'
            );
        }

        public function test_report() {
            $reporter = new Phest_Report_Console();

            $this->assertOutput(
                function() use($reporter) {
                    $this->assertTrue($reporter->report());
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('1 OK'));
                }
            );

            $this->assertOutput(
                function() use($reporter) {
                    $this->assertFalse(
                        $reporter->report(new Phest_Exception('dummy'), 1)
                    );
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('2 NOT OK line:1 dummy'));
                }
            );
        }
    }
?>
