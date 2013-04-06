<?php
    require_once dirname(__FILE__)."/../Phest.php";

    $pid = pcntl_fork();

    if ($pid == 0) {
        pcntl_exec(
            "/home/kinjouj/.phpbrew/php/php-5.4.13/bin/php",
            array("-S", "localhost:8080", "-t", dirname(__FILE__).'/../public')
        );
    } else if($pid) {
        sleep(1);

        $res = file_get_contents('http://localhost:8080/index.php');

        assertThat($res, is("/index.php"));

        posix_kill($pid, SIGINT);
    }
