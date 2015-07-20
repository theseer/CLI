<?php
namespace TheSeer\CLI {

    class Request {

        /**
         * @var string[]
         */
        private $argv;

        /**
         * @var string
         */
        private $command;

        /**
         * @var CommandOptions
         */
        private $options;

        /**
         * @param array $argv
         */
        public function __construct(array $argv) {
            $this->argv = $argv;
        }

        public function getCommand() {
            $this->parse();
            return $this->command;
        }

        /**
         * @return CommandOptions
         */
        public function getCommandOptions() {
            $this->parse();
            return $this->options;
        }

        private function parse() {
            if ($this->command !== NULL) {
                return;
            }

            if (count($this->argv) == 1) {
                $this->command = 'help';
                $this->options = new CommandOptions([]);
                return;
            }

            if (count($this->argv) >= 2) {
                $this->command = $this->argv[1];
                $this->options = new CommandOptions(array_slice($this->argv, 2));
                return;
            }

            $this->options = new CommandOptions([]);
        }

    }

}
