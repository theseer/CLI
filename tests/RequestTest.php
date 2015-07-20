<?php
namespace TheSeer\CLI {

    class RequestTest extends \PHPUnit_Framework_TestCase {

        /**
         * @dataProvider cliCommandProvider
         *
         * @param array  $cliArguments
         * @param string $expectedCommand
         */
        public function testReturnsExpectedCommand(array $cliArguments, $expectedCommand) {
            $request = new Request($cliArguments);
            $this->assertSame($expectedCommand, $request->getCommand());
        }

        public function cliCommandProvider() {
            return [
                [['foo'], 'help'],
                [['foo', 'bar'], 'bar'],
                [[], null]
            ];
        }

        /**
         * @dataProvider cliCommandOptionsProvider
         *
         * @param array             $cliArguments
         * @param CLICommandOptions $expectedOptions
         */
        public function testReturnsExpectedCommandOptions(array $cliArguments, CommandOptions $expectedOptions) {
            $request = new Request($cliArguments);
            $this->assertEquals($expectedOptions, $request->getCommandOptions());
        }

        public function cliCommandOptionsProvider() {
            return [
                [[], new CommandOptions([])],
                [['foo'], new CommandOptions([])],
                [['foo', 'bar', 'baz'], new CommandOptions(['baz'])]
            ];
        }

    }

}

