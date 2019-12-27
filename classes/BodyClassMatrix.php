<?php
class BodyClassMatrix {
    private static $instance;
    private $class;

    private function __construct() {
        $this->class = array();
    }

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function add($class) {
        $this->class[] = $class;
    }

    public function get() {
        return $this->class;
    }
}
?>