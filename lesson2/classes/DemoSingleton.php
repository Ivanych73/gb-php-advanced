<?php

    require_once('traits.php');

    class DemoSingleton {
        private static $_instance = null;
        private function __construct() {
        }
        protected function __clone() {
        }
        protected function __wakeup() {
        }
        static public function getInstance() {
            if(is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        use DemoEcho;
    }

?>