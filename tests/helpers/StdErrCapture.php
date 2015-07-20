<?php
namespace TheSeer\CLI {

    class StdErrCapture extends \php_user_filter {

        private static $buffer = '';
        private static $handle;

        /**
         * @param resource $stream
         */
        public static function init() {
            stream_filter_register("capture", self::class);
            self::$handle = stream_filter_append(STDERR, "capture", STREAM_FILTER_WRITE);
        }

        public static function done() {
            stream_filter_remove(self::$handle);
        }

        public static function getBuffer() {
            return self::$buffer;
        }

        public function filter($in, $out, &$consumed, $closing) {
            while ($bucket = stream_bucket_make_writeable($in)) {
                self::$buffer .= $bucket->data;
                $consumed += $bucket->datalen;
                //stream_bucket_append($out, $bucket);
            }
            return PSFS_PASS_ON;
        }
    }
}
