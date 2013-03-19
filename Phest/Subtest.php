<?php
    class Phest_Subtest {
        public static function runSubtest($comment, callable $cb) {
            if (empty($comment)) {
                throw new Phest_Exception("subtest comment is empty");
            }

            $ctx = Phest_Context::getInstance();

            $ctxSubtest = Phest_Context::newInstance();
            $reporter = $ctxSubtest->getReporter();
            $reporter->write("%g--- $comment%n\n");
            $reporter->indentLevel++;

            $cb();

            $ctx->addSubtest($ctxSubtest);

            Phest_Context::setInstance($ctx);
        }
    }

    function subtest($comment, callable $cb) {
        Phest_Subtest::runSubtest($comment, $cb);
    }
