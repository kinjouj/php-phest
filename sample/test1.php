<?php
    require_once dirname(__FILE__).'/../lib/Phest.php';

    assertThat('A', is('A'));
    assertThat('B', is('B'));

    subtest('subtest1', function() {
        assertThat('C', is('C'));
    });
?>
