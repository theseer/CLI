<?php
namespace TheSeer\CLI {

    /**
     * @covers TheSeer\CLI\CommandOptions
     */
    class CommandOptionsTest extends \PHPUnit_Framework_TestCase {

        /**
         * @expectedException \TheSeer\CLI\CommandOptionsException
         * @expectedExceptionCode \TheSeer\CLI\CommandOptionsException::NoSuchOption
         */
        public function testRequestingNonExistingOptionThrowsException() {
            $instance = new CommandOptions([]);
            $instance->getOption('foo');
        }

        /**
         * @expectedException \TheSeer\CLI\CommandOptionsException
         * @expectedExceptionCode \TheSeer\CLI\CommandOptionsException::InvalidArgumentIndex
         */
        public function testRequestingNonExistingArgumentThrowsException() {
            $instance = new CommandOptions([]);
            $instance->getArgument(100);
        }

        public function testOptionsGetParsedCorrectlyWhenValueIsAssignedWithEqualSign() {
            $instance = new CommandOptions(['--foo=abc']);
            $this->assertEquals('abc', $instance->getOption('foo'));
        }

        public function testOptionsGetParsedCorrectlyWhenValueIsAssignedWithSpace() {
            $instance = new CommandOptions(['--foo', 'abc', 'more']);
            $this->assertEquals('abc', $instance->getOption('foo'));
        }

        public function testSwitchesGetParsedFromRequest() {
            $instance = new CommandOptions(['--bar=abc','-f','bar']);
            $this->assertTrue($instance->isSwitch('f'));
            $this->assertFalse($instance->isSwitch('x'));
        }

        public function testArgumentsAreParsedCorrectlyFromRequest() {
            $instance = new CommandOptions(['--foo', 'abc', '-f', 'arg1','arg2']);
            $this->assertEquals(2, $instance->getArgumentCount());
            $this->assertEquals('arg1', $instance->getArgument(0));
            $this->assertEquals('arg2', $instance->getArgument(1));
        }

    }

}
