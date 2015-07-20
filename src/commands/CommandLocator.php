<?php
namespace TheSeer\CLI {

    interface CommandLocator {

        /**
         * @param Request $request
         *
         * @throws CommandLocatorException
         * @return Command
         */
        public function getCommandForRequest(Request $request);

    }

}
