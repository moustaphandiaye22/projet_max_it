<?php

namespace App\Core\Abstract;

abstract class AbstractEntity
{
    abstract public function toArray(): array; 
    public function toobject($data): object
    {
        return (object) $data;
    }
    public function tojson(): string
    {
        return json_encode($this->toArray());
    }
    public function __get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \Exception("Property {$name} does not exist in " . get_class($this));
        }
        return $this->$name;
    }
    public function __set($name, $value)
    {
        if (!property_exists($this, $name)) {
            throw new \Exception("Property {$name} does not exist in " . get_class($this));
        }
        $this->$name = $value;
    }
}
