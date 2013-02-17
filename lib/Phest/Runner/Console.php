<?php
    require_once 'Console/CommandLine.php';
    require_once dirname(__FILE__).'/../../Phest.php';

    class Phest_Runner_Console {

        private $parsedCommandLine;

        public function __construct() {
            $this->parseArgs();
        }

        public function runTests() {
            if ($this->parsedCommandLine instanceof Console_CommandLine_Result) {
                $args = $this->parsedCommandLine->args;

                if (is_array($args)) {
                    if (isset($args['files'])) {
                        $files = $args['files'];

                        if (is_array($files)) {
                            foreach ($files as $file) {
                                if (!file_exists($file)) {
                                    continue;
                                }

                                $path = realpath($file);

                                echo "$path ...\n";

                                try {
                                    include($path);
                                } catch (TestFailureException $e) {
                                    echo $e->getMessage(), "\n";
                                }
                            }
                        }
                    }
                }
            }
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
