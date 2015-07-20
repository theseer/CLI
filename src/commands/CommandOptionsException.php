<?php
namespace TheSeer\CLI {

    class CommandOptionsException extends \Exception {
        const NoSuchOption = 1;
        const InvalidArgumentIndex = 2;
    }

}
