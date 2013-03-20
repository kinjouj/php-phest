<?php
    require_once dirname(__FILE__).'/class.php';

    class Phest_Assert_Plan_TestCase extends TestCase {

        public function test_evaluate() {
            $this->assertOutput(
                function() {
                    $this->assertFalse(Phest_Assert_Plan::evaluate("1"));
                },
                function($output) {

                }
            );

            $this->tearDown();

            $this->assertOutput(
                function() {
                    $this->assertFalse(Phest_Assert_Plan::evaluate(1));
                },
                function($output) {
                    $this->assertThat(
                        $output,
                        $this->equalTo('1 NOT OK line:0 plan got 0 !== expected 1')
                    );
                }
            );

            $this->tearDown();

            $this->assertOutput(
                function() {
                    $this->assertTrue(Phest_Assert_Plan::evaluate(0));
                },
                function($output) {
                    $this->assertThat($output, $this->equalTo('1 OK'));
                }
            );
        }
    }
?>
