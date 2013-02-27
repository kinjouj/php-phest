<?php
    require_once 'Console/CommandLine.php';
    require_once dirname(__FILE__).'/../Context.php';

    class Phest_Runner_Console {

        private $parsedCommandLine;

        public function __construct() {
            $this->parseArgs();
        }

        public function runTests() {
            $files = $this->getTestFiles();
            $tests = [];

            foreach ($files as $file) {
                if (!file_exists($file) || !is_file($file)) {
                    continue;
                }

                $ctx = Phest_Context::newInstance();
                $ctx->run(realpath($file));

                $tests[] = $ctx;
            }

            $a = array_reduce(
                $tests,
                function($x, $y) {
                    return ($x + $y->getCount());
                },
                0
            );
        }

        private function getArgs() {
            $args = array();

            if ($this->parsedCommandLine instanceof Console_CommandLine_Result) {
                $args = $this->parsedCommandLine->args;
            }

            return $args;
        }

        private function getTestFiles() {
            $files = array();
            $args = $this->getArgs();

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

            return $files;
        }

        private function parseArgs() {
            $parser = new Console_CommandLine();
            $parser->addArgument(
                'files',
                array(
                    'multiple' => true
                )
            );
            $parser->addOption(
                'coverage',
                array(
                    'short_name' => '-c',
                    'long_name' => '--coverage'
                )
            );

            $parser->addOption(
                'version',
                array(
                    'short_name' => '-v',
                    'long_name' => '--version'
                )
            );

            $parser->addOption(
                'verbose',
                array(
                    'short_name' => '-V',
                    'long_name' => '--verbose'
                )
            );

            try {
                $this->parsedCommandLine = $parser->parse();
            } catch (Console_CommandLine_Exception $e) {
                $parser->displayError($e->getMessage());
            }
        }
    }
