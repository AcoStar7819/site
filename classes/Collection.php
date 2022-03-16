<?php

/**
 * Базовая реализация коллекции для хранения любых данных
 */
class Collection
{
    private $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function __set(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}