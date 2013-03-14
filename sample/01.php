<?php
    require_once dirname(__FILE__).'/../Phest.php';

    assertThat('A', is('A'));
    assertThat('B', is('C'));
    assertThat('B', is('B'));

    subtest('subtest1', function() {
        assertThat('C', is('C'));

        subtest('subtest2', function() {
            assertThat('B', is('B'));
            assertThat('A', is('A'));
            assertThat('A', is('A'));

            subtest('subtest3', function() {
                assertThat('A', is('A'));
            });
        });
    });

    assertThat('B', is('B'));
?>
