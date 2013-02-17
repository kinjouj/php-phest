<?php
    //require 'lib/Test/More.php';
    require dirname(__FILE__).'/../lib/Phest/Assert/That.php';
    require dirname(__FILE__).'/../lib/Phest/Assert/That/Is.php';

    assertThat('A', is('A'));
    assertThat('B', is('C'));
?>
