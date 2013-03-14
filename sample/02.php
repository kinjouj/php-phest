<?php
    class Sample {
        public function repeat($n) {
            return str_repeat('x', $n);
        }
    }

    $sample = new Sample();
    assertThat($sample, notNullValue($sample));
    assertThat($sample->repeat(2), is('xx'));
