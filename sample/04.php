<?php
    function describe($comment, $cb) {
        subtest($comment, $cb);
    }

    function it($comment, $cb) {
        describe($comment, $cb);
    }

    describe('describe1', function() {
        assertThat('hoge', is('hoge'));

        it('it1', function() {
            assertThat('fuga', is('fuga'));
        });
    });
