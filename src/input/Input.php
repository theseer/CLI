<?php
namespace TheSeer\CLI;

interface Input {

    /**
     * @param string $message
     *
     * @return bool
     */
    public function confirm($message);
}
