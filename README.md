# phest: PHP Simple Testing


# example

    <?php

        require_once 'phest.php';

        assertThat('A', is('A'));
        assertThat('B', is('B'));

        subtest('subtest1', function() {
            assertThat('A', is('A'));
        });
    ?>
