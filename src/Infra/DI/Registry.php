<?php

namespace App\Infra\DI;

class Registry
{
    private static $instance;
    private $data;

    private function __construct()
    {
        $this->data = [];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }
}