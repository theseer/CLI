<?php
namespace TheSeer\CLI {

    class Runner {

        /**
         * @var CommandLocator
         */
        private $locator;

        public function __construct(CommandLocator $locator) {
            $this->locator = $locator;
        }

        public function run(Request $request) {
            ExceptionHandler::register();
            try {
                $this->locator->getCommandForRequest($request)->execute();
            } catch (CommandLocatorException $e) {
                if ($e->getCode() == CommandLocatorException::UnknownCommand) {
                    fwrite(STDERR,
                        sprintf("Unknown command '%s'\n\n", $request->getCommand())
                    );
                } else {
                    throw $e;
                }
            }
        }

    }

}
