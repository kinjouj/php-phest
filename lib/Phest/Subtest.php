<?php
    class Phest_Subtest {
        public static function runSubtest($comment, callable $cb) {
            if (empty($comment)) {
                throw new Phest_Exception("subtest comment is empty");
            }

            $ctx = Phest_Context::getInstance();
            $ctx->addSubtest(Phest_Context::newInstance(null));
            $ctx->getReporter()->write("%g--- $comment%n");

            $cb();
        }
    }

    function subtest($comment, callable $cb) {
        Phest_Subtest::runSubtest($comment, $cb);
    }
