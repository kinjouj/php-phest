<?php
    class Sample {
        public function repeat($n) {
            return str_repeat('x', $n);
        }
    }

    $sample = new Sample();
    assertThat($sample, notNullValue());
    assertThat($sample->repeat(2), is('xx'));
    assertThat($sample->repeat(3), is("xxxxx"));

    plan(3);
?>
