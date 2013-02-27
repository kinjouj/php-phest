<?php
    require_once dirname(__FILE__).'/../lib/Phest/Assert/That.php';
    require_once dirname(__FILE__).'/../lib/Phest/Assert/That/Is.php';

    assertThat('A', is('A'));
    assertThat('B', is('C'));
    assertThat('C', is('C'));
?>
