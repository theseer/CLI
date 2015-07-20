<?php
namespace TheSeer\CLI {

    /**
     * @covers TheSeer\CLI\Runner
     */

    class RunnerTest extends \PHPUnit_Framework_TestCase {

        public function testValidCLIRequestGetsExecuted() {
            $request = new Request([]);
            $command = $this->prophesize(Command::class);

            $locator  =  $this->prophesize(CommandLocator::class);
            $locator->getCommandForRequest($request)->willReturn($command->reveal())->shouldBeCalled();

            $cli = new Runner($locator->reveal());
            $cli->run($request);
        }

        /**
         * @expectedException \RuntimeException
         */
        public function testGeneralExceptionsArePassedOn() {
            $request = new Request([]);
            $locator  =  $this->prophesize(CommandLocator::class);
            $locator->getCommandForRequest($request)->willThrow(new \RuntimeException());
            $cli = new Runner($locator->reveal());
            $cli->run($request);
        }

        /**
         * @expectedException \TheSeer\CLI\CommandLocatorException
         */
        public function testLocatorExceptionsOtherThanUnknownCommandArePassedOn() {
            $request = new Request([]);
            $locator  =  $this->prophesize(CommandLocator::class);
            $locator->getCommandForRequest($request)->willThrow(new CommandLocatorException('foo'));
            $cli = new Runner($locator->reveal());
            $cli->run($request);
        }

        public function testUnknownCommandExceptionsReportToStdErr() {
            $request = new Request(['help']);
            $locator  =  $this->prophesize(CommandLocator::class);
            $locator->getCommandForRequest($request)->willThrow(new CommandLocatorException('...', CommandLocatorException::UnknownCommand));
            $cli = new Runner($locator->reveal());

            StdErrCapture::init();
            $cli->run($request);
            StdErrCapture::done();

            $this->assertEquals("Unknown command 'help'\n\n", StdErrCapture::getBuffer());

        }
    }

}
