<?php

namespace App\Helpers;


class SimpleClass implements \JsonSerializable {
    protected $_attributes = [];

    public function __construct($attributes = []) {
        $this->setAttributes($attributes);
    }

    public function __set($name, $value) {
        $this->setAttribute($name, $value);
    }

    public function __get($name) {
        return $this->getAttribute($name);
    }

    public function __isset($name) {
        return in_array($name, $this->_attributes, true);
    }

    public function setAttribute($name, $value) {
        $setter = 'set' . studly_case($name);

        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            $this->_attributes[$name] = $value;
        }
    }

    public function getAttribute($name) {
        $getter = 'get' . studly_case($name);

        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return $this->_attributes[$name] ?? null;
        }
    }

    public function setAttributes($data) {
        foreach ($data as $name => $value) {
            $this->setAttribute($name, $value);
        }
    }

    public function getAttributes(array $only = null) {
        $data = [];
        $availableAttributes = array_keys($this->_attributes);
        if ($only) {
            $availableAttributes = array_intersect($availableAttributes, $only);
        }

        foreach ($availableAttributes as $attribute) {
            $data[$attribute] = $this->getAttribute($attribute);
        }

        return $data;
    }

    public function __toString() {
        return json_encode($this->getAttributes());
    }

    public function jsonSerialize() {
        return $this->getAttributes();
    }
}