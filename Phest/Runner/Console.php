<?php
    require_once 'Console/CommandLine.php';
    require_once dirname(__FILE__).'/../Context.php';

    class Phest_Runner_Console {

        private $parsedCommandLine;
        private $tests = [];

        public function __construct() {
        }

        public function __destruct() {
            if (empty($this->tests)) {
                return;
            }

            $reporter = Phest_Context::getInstance()->getReporter();
            $reporter->write("\r\n");
            $reporter->write("%2");
            $reporter->write("Test: {$this->getNumTests()}, ");
            $reporter->write("Assertions: {$this->getNumAssertions()}");
            $reporter->write("%n\r\n");
        }

        public function getNumTests() {
            return count($this->tests);
        }

        public function getNumAssertions() {
            $numAssertions = 0;

            foreach ($this->tests as $testContext) {
                $numAssertions += $testContext->getCountByAll();
            }

            return $numAssertions;
        }

        public function runTests() {
            $files = $this->getTestFiles();

            foreach ($files as $file) {
                if (!file_exists($file) || !is_file($file)) {
                    continue;
                }

                $ctx = Phest_Context::newInstance();
                $ctx->run(realpath($file));

                $this->tests[] = $ctx;

                $ctx->getReporter()->write("\r\n");
            }
        }

        private function getTestFiles() {
            $files = array();

            $commandLine = $this->parseArgs();

            if ($commandLine instanceof Console_CommandLine_Result) {
                $args = $commandLine->args;

                if (is_array($args)) {
                    if (isset($args['files']) && is_array($args['files'])) {
                        foreach ($args['files'] as $file) {
                            if (!file_exists($file)) {
                                continue;
                            }

                            if (is_dir($file)) {
                                $itr = new DirectoryIterator($file);

                                foreach ($itr as $entry) {
                                    if ($entry->isDot()) {
                                        continue;
                                    }

                                    $files[] = $entry->getPathname();
                                }
                            } else {
                                $files[] = $file;
                            }
                        }
                    }
                }
            }

            if (count($files) > 1) {
                natsort($files);
            }

            return $files;
        }

        private function parseArgs() {
            $parser = new Console_CommandLine();
            $parser->addArgument(
                'files',
                array('multiple' => true, 'optional' => true)
            );
            $parser->addOption(
                'coverage',
                array('short_name' => '-c', 'long_name' => '--coverage')
            );

            $parser->addOption(
                'version',
                array('short_name' => '-v', 'long_name' => '--version')
            );

            try {
                return $parser->parse();
            } catch (Console_CommandLine_Exception $e) {
                $parser->displayError($e->getMessage());
            }
        }
    }
